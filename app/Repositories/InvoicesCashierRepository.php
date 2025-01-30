<?php
namespace App\Repositories;

use App\Interfaces\InvoicesCashierRepositoryInterface;
use App\Models\Invoice;
use App\Models\InvoiceCashier; // Import the Invoice model
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesCashierRepository implements InvoicesCashierRepositoryInterface
{
    public function index(Request $request)
    {
        // Validate the dates
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date',
            'type'       => 'nullable|in:all,cash,knet',
        ]);

        // Retrieve or set default dates
        $start_date   = $request->input('start_date') ?? date('Y-m-01');
        $end_date     = $request->input('end_date') ?? date('Y-m-t');
        $payment_type = $request->input('type', 'all');

        // Fetch invoices based on filters
        $invoices = InvoiceCashier::whereBetween('date', [strtotime($start_date), strtotime($end_date)])
            ->when($payment_type !== 'all', function ($query) use ($payment_type) {
                return $query->where('payment_type', $payment_type);
            })
            ->orderBy('id', 'asc')
            ->get();

        // Add client names to invoices
        foreach ($invoices as &$invoice) {
            $invoice->client_name = $invoice->order_id > 0 ? $this->get_client_name($invoice->order_id) : 'تصدير';
        }
        $view         = 'invoices.index';
        $central_bank = DB::table('invoices_central_bank')->where('slug', 'cashier')->first();

        $title      = 'حساب الكاشير';
        $breadcrumb = [
            ['title' => "الرئيسية", 'url' => route("dashboard")],
            ['title' => $title, 'url' => 'javascript:void(0);'],
        ];

        return view('layout', compact('title', 'view', 'invoices', 'payment_type', 'start_date', 'end_date', 'central_bank', 'breadcrumb'));
    }

    public function all_invoices_dates($start_date, $end_date, $payment_method)
    {
        $invoices = InvoiceCashier::whereBetween('date', [$start_date, $end_date])
            ->when(in_array($payment_method, ['cash', 'knet']), function ($query) use ($payment_method) {
                return $query->where('payment_type', $payment_method);
            })
            ->orderBy('id', 'asc')
            ->get();

        return $invoices;
    }

    public function get_client_name($order_id)
    {
        $invoice = InvoiceCashier::with('order.client')->where('order_id', $order_id)->first();
        return $invoice && $invoice->order ? $invoice->order->client->name_ar : '';
    }
    public function processExport(Request $request)
    {
        $exports = InvoiceCashier::where('type', 'export')->get();

        $request->validate([
            'payment_file_dir' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // Validate file upload
        ]);

        if ($request->hasFile('payment_file_dir')) {
            // Store the uploaded file
            $uploadedFile = $request->file('payment_file_dir');
            $filePath     = $uploadedFile->store('invoices_cashier', 'public');

            // Prepare data for update
            $updateData = [
                'img_dir' => "/storage/" . $filePath,
                'user_id' => auth()->user()->id ?? null, // Replace with logged-in user
            ];

            if ($exports->isNotEmpty()) {
                $updateData['invoice_id'] = $exports->first()->id;

                // Update the invoices table with the export data
                Invoice::where('come_from', 'cashier')->update($updateData);

                return redirect()->route('invoices_cashier.index')->with('success', 'تم تصدير الفواتير بنجاح');
            }

            return redirect()->route('invoices_cashier.index')->with('error', 'لا توجد فواتير تصدير للتحديث');
        }
    }
    public function showExportForm()
    {
        $exports = InvoiceCashier::where('type', 'export')->get();

        $view       = 'invoices.get_invoices_papers';
        $title      = 'تصدير الحسابات';
        $breadcrumb = [
            ['title' => "الرئيسية", 'url' => route("dashboard")],
            ['title' => $title, 'url' => 'javascript:void(0);'],
        ];
        $items = $exports;

        return view('layout', compact(
            'title',
            'items',
            'view', 'breadcrumb'
        ));
    }

}

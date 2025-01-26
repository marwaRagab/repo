<?php
namespace App\Repositories;

use App\Interfaces\InvoicesCashierRepositoryInterface;
use App\Models\InvoiceCashier;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesCashierRepository implements InvoicesCashierRepositoryInterface
{
    public function index()
    {
        $firstDay = strtotime('first day of this month');
        $lastDay  = strtotime('first day of next month');

        $title      = 'حساب الكاشير';
        $breadcrumb = [
            ['title' => "الرئيسية", 'url' => route("dashboard")],
            ['title' => $title, 'url' => 'javascript:void(0);'],
        ];

        $args         = func_get_args();
        $payment_type = empty($args) ? '' : $args[0];
        $slug         = $payment_type;

        $invoices = $this->all_invoices_dates($firstDay, $lastDay, $payment_type);

        foreach ($invoices as &$invoice) {
            $invoice->client_name = $invoice->order_id > 0 ? $this->get_client_name($invoice->order_id) : 'تصدير';
        }

        $central_bank = DB::table('invoices_central_bank')->where('slug', 'cashier')->first();

        $view = 'invoices.index';

        return view('layout', compact('title', 'view', 'breadcrumb', 'invoices', 'slug', 'central_bank'));
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
        return $invoice && $invoice->order ? $invoice->order->client->name : '';
    }

    public function show($id)
    {
        $invoice = InvoiceCashier::findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'      => 'required|numeric',
            'description' => 'required|string|max:255',
        ]);

        $invoice              = new InvoiceCashier();
        $invoice->amount      = $request->amount;
        $invoice->description = $request->description;
        $invoice->save();

        return redirect()->route('invoices_cashier.index')->with('success', 'Invoice created successfully.');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'amount'      => 'required|numeric',
            'description' => 'required|string|max:255',
        ]);

        $invoice              = InvoiceCashier::findOrFail($id);
        $invoice->amount      = $request->amount;
        $invoice->description = $request->description;
        $invoice->save();

        return redirect()->route('invoices_cashier.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = InvoiceCashier::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices_cashier.index')->with('success', 'Invoice deleted successfully.');
    }
}

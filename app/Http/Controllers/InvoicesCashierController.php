<?php
namespace App\Http\Controllers;


use App\Interfaces\InvoicesCashierRepositoryInterface;



use Illuminate\Http\Request;
class InvoicesCashierController extends Controller
{
    protected $invoicesCashierRepository;

    public function __construct(InvoicesCashierRepositoryInterface $invoicesCashierRepository)
    {
        $this->invoicesCashierRepository = $invoicesCashierRepository;
    }

    public function index()
    {
        return $this->invoicesCashierRepository->index();
    }

    public function show($id)
    {
        return $this->invoicesCashierRepository->show($id);
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        return $this->invoicesCashierRepository->store($request);
    }

    public function edit($id)
    {
        $invoice = $this->invoicesCashierRepository->show($id);
        return view('invoices.edit', compact('invoice'));
    }

    public function update($id, Request $request)
    {
        return $this->invoicesCashierRepository->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->invoicesCashierRepository->destroy($id);
    }
}
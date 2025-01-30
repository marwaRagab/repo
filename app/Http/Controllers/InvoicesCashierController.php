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

    public function index(Request $request)
    {
        return $this->invoicesCashierRepository->index($request);
    }

    public function processExport(Request $request)
    {
        return $this->invoicesCashierRepository->processExport($request);
    }
    public function showExportForm()
    {
        return $this->invoicesCashierRepository->showExportForm();
    }
}
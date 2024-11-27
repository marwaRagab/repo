<?php

namespace App\Interfaces\ImportingCompanies;

use Illuminate\Http\Request;

interface TawreedRepositoryInterface
{
    public function listCompanies();
    public function getCompanyById($companyId);
    public function searchProducts($request, $classId);
    public function searchResults($request, $classId);
    public function addToCart($request);
    public function createCart($request);
    public function deleteFromCart($product_id);
    public function clearCart();
    public function addToPurchaseOrders();
    public function getAllPurchaseOrders($request);
    public function sending($request, $id);
    public function deletePurchaseOrder($id);
    public function PurchaseOrdersArchive($request);
    public function print_order_company($order_id);
    // public function print_purchase($order_id);

}

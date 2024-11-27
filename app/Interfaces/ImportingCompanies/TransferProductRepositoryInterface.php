<?php

namespace App\Interfaces\ImportingCompanies;

use Illuminate\Http\Request;

interface TransferProductRepositoryInterface
{
    public function index();
    public function getAvailableProductsByClassId($classId);
    public function delete_available_product($id);
    public function addToCart($request);
    public function viewCart();
    public function deleteFromCart($id);
    public function transfer($request);
}

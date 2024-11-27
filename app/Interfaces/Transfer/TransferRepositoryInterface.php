<?php

namespace App\Interfaces\Transfer;

interface TransferRepositoryInterface
{
    public function getAvailableProducts();
    public function getAvailableProductsByClassId($classId);
    public function delete_available_product($id);
}

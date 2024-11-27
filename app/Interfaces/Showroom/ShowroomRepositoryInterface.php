<?php

namespace App\Interfaces\Showroom;

use Illuminate\Http\Request;

interface ShowroomRepositoryInterface
{
    public function getOrders();
    public function updateOrder(Request $request, $id);
    public function getAll();
    public function add_serial(Request $request, $id);
   
}

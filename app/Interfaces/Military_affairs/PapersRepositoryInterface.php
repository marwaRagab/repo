<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface PapersRepositoryInterface
{
    public function index();
    public function eqrar_not_received();
    public function eqrar_received();
   // public function getall_eqrar();
    public function to_eqrar_dain(Request $request);
    public function to_open_file(Request $request);
    public function get_count_eqrar_dain($slug = null);
    public function nmozag_eqrar($id);
}

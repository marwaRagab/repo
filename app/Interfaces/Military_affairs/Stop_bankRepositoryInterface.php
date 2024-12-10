<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Stop_bankRepositoryInterface
{
    public function index (Request $request);

    public function archive (Request $request);

    public function print_archive (Request $request);
    public function change_states (Request $request);
    public function  change_states_bank($id,$value);


}

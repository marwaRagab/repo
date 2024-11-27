<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Excute_actionsRepositoryInterface
{
    public function index (Request $request);
    public function all_checks_index (Request $request);
    public function add_amount(Request $request);

    public function add_check(Request $request);
    public function add_check_finished(Request $request);

}

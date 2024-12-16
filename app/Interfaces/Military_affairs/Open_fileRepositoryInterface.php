<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Open_fileRepositoryInterface
{
    public function index (Request $request);
    public function index_case_proof (Request $request);
    public function return_to_lated(Request $request);
    public function add_notes(Request $request);

   public function convert_to_execute(Request $request);
   public function convert_ex_alert(Request $request);

   public function update_responsible(Request $request);


}

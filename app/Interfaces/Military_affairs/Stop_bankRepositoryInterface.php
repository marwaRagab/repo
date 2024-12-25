<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Stop_bankRepositoryInterface
{
    public function index (Request $request);

    public function archive (Request $request);

    public function print_archive (Request $request);

    public function check_info_in_banks ( $id);

    public function check_info_in_job ( $id);
    public function saveBanksInfo (Request $request);

    public function save_jobs_info (Request $request);
    public function change_states (Request $request);
    public function  change_states_bank($id,$value);

    public function stop_bank_request_results(Request $request);


}

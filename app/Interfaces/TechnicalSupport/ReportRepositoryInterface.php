<?php

namespace App\Interfaces\TechnicalSupport;

use Illuminate\Http\Request;

interface ReportRepositoryInterface
{
    public function index();
    public function prbs_num(Request $request);
    public function timeline(Request $request);
    public function progress(Request $request);
}

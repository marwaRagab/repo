<?php

namespace App\Http\Controllers\TechnicalSupport;

use App\Http\Controllers\Controller;
use App\Interfaces\TechnicalSupport\ReportRepositoryInterface;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function index()
    {
        return $this->reportRepository->index();
    }

    public function prbs_num(Request $request)
    {
        return $this->reportRepository->prbs_num($request);
    }

    public function timeline(Request $request)
    {
        return $this->reportRepository->timeline($request);
    }

    public function progress(Request $request)
    {
        return $this->reportRepository->progress($request);
    }
}
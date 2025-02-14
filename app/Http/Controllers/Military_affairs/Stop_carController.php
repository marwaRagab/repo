<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Stop_carRepositoryInterface;
use Illuminate\Http\Request;

class Stop_carController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Stop_carRepositoryInterface $Stop_carRepository)
    {
        $this->Stop_carRepository = $Stop_carRepository;
    }
    public function index(Request $request)
    {
        return $this->Stop_carRepository->index($request);

    }
    public function updateRegionsPoliceStations()
    {
        return $this->Stop_carRepository->updateRegionsPoliceStations();
    }
    public function getprevCols()
    {
        return $this->Stop_carRepository->getprevCols();
    }
    public function update_info_cars_numbers($id, Request $request)
    {
        return $this->Stop_carRepository->update_info_cars_numbers($id,$request);
    }

    public function stop_car_convert(Request $request)
    {
        return $this->Stop_carRepository->stop_car_convert($request);
    }
    public function info_update(Request $request)
    {
        return $this->Stop_carRepository->info_update($request);
    }
    public function catchCarDone($id, Request $request)
    {
        return $this->Stop_carRepository->catchCarDone($id,$request);
    }
    public function send_sms($id)
    {
        return $this->Stop_carRepository->send_sms($id);
    }
}
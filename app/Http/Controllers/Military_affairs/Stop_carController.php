<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Stop_carRepositoryInterface;

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
    public function index($governate_id = null, $stop_car_type = null)
    {
        return $this->Stop_carRepository->index($governate_id, $stop_car_type);

    }

}
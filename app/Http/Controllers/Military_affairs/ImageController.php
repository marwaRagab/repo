<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\ImageRepositoryInterface;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(ImageRepositoryInterface $ImageRepository)
    {
        $this->ImageRepository = $ImageRepository;
    }
    public function index(Request $request)
    {
        return $this->ImageRepository->index($request);

    }
    public function to_a3lan_eda3(Request $request)
    {
        return $this->ImageRepository->to_a3lan_eda3($request);
    }
    public function athbat_7ala($id)
    {
        return $this->ImageRepository->index($id);
    }

}

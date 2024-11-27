<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\SearchRepositoryInterface;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SearchController extends Controller
{
    
    protected $searchRepository;

    public function __construct(SearchRepositoryInterface $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    public function index(Request $request)
    {
        return $this->searchRepository->index($request);
    } 
    public function get_searched(Request $request)
    {
        return $this->searchRepository->get_searched($request);
    }
    public function show_images($id)
    {
        return $this->searchRepository->show_images($id);
    }

}

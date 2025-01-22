<?php

namespace App\Http\Controllers\Clientclient;

use App\Http\Controllers\Controller;
use App\Interfaces\Showroom\ClientRepositoryInterface;
use App\Models\Company;
use App\Models\ImportingCompanies\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;



class ClientController extends Controller
{
    protected $client;

    public function __construct(ClientRepositoryInterface $client)
    {
        $this->client = $client;
    }
    public function index()
    {        
      return $this->client->index();
    }
    public function get_data(Request $request)
    {
        return $this->client->get_data($request);
    }

}

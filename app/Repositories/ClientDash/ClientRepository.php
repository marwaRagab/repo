<?php

namespace App\Repositories\ClientDash;

use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{

    public function index()
    {
        $title = "الموظفين";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.members';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'members')
        );
    }
    public function get_data(Request $request)
    {
        return Client::with('installments')->get();
    }

   
}

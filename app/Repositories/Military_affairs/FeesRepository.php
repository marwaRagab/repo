<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\FeesRepositoryInterface;
use App\Models\Military_affairs\Military_affair;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class FeesRepository implements FeesRepositoryInterface
{
    protected $data;

    public function __construct()
    {
      

    }

    public function index(Request $request)
    {

        $checking_type = $request->checking_type;
        $message = "تم دخول صفحة فتح رفع الاجراءات";
        $user_id = 1;
        //$user_id =  Auth::user()->id,
        // $this->log($user_id ,$message);
        // $user_id =  Auth::user()->id;
        $this->data['title'] = 'رفع الاجراءات';
        $this->data['items'] = Military_affair_fees::get();


        $title = '  رفع الاجراءات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        foreach ($this->data['items'] as $value) {
            $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last() : '');

        }
        $this->data['view'] = 'military_affairs/Checking/index';
        return view('layout', $this->data, compact('breadcrumb'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);


        if ($request->hasFile('img_dir')) {
            $data_img_dir = $request->file('img_dir')->store('military_affairs', 'public'); // Store in the 'products' directory
        }
        $item_military_affairs = Military_affair::findorfail($request->military_affairs_id);

        $data['actions_up'] = 0;
        $data['img_dir'] = $data_img_dir;

        if ($request->convert_type) {
            $data['archived_img_dir'] = $data_img_dir;

            $data['archived'] = 1;

        }

        $item_military_affairs->update($data);
        return redirect()->route('checking');


    }

    public function delete(Request $request)
    {

    }

}

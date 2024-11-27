<?php

namespace App\Http\Controllers\Military_affairs;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\military_affairs_notes;
use App\Models\military_affairs_deligation;
use App\Models\Military_affairs\Military_affair;

class DelegatesController extends Controller
{
    public function index()
    {
        $title = 'المسئولين ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المسئولين";
        $breadcrumb[1]['url'] = route("military_affairs.delegates");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data = User::where('type' , 'emp')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.index';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }
    
    public function update(Request $request, $id)
    {
        // Find the item by its ID
        $item = User::findOrFail($id);

        // Update the set_delegate field
        $item->set_delegate = $request->input('set_delegate');
        $item->save();

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Delegate status updated successfully.');
    }

    public function get_statistics()
    {
        $title = 'احصائيات المسئولين ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المسئولين";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['users'] = User::where('type' , 'emp')->get();

        $data['delegates'] = military_affairs_deligation::get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.get_statistics';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }

    public function get_statistics_details($user_id)
    {
        $title = 'الملفات المفتوحة ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الملفات المفتوحة";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['users'] = User::where('type' , 'emp')->get();

        $data['delegates'] = military_affairs_deligation::where('emp_id', $user_id)->where('end_date' , null)->with('militaryAffair')->get();
        // dd($data['delegates'] );
        // $data['delegates'] = Military_affair::where('emp_id', $data['delegate_user']->emp_id)->with('installment')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.get-statistics-details';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }

    public function get_statistics_deligations($user_id)
    {
        $title = 'الملفات المغلقة ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الاحصائيات";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['users'] = User::where('type' , 'emp')->get();

        $data['delegates'] = military_affairs_deligation::where('emp_id', $user_id)->whereNotNull('end_date')->with('militaryAffair')->get();
        // dd($data['delegates'] );
        // $data['delegates'] = Military_affair::where('emp_id', $data['delegate_user']->emp_id)->with('installment')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.get-statistics-deligations';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }
    public function get_statistics_notes_details($user_id)
    {
        $title = 'الملاحظات ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الاحصائيات";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['users'] = User::where('type' , 'emp')->get();

        $data['delegates'] = military_affairs_notes::where('created_by', $user_id)->get();
        // dd($data['delegates'] );
        // $data['delegates'] = Military_affair::where('emp_id', $data['delegate_user']->emp_id)->with('installment')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.get-statistics-notes-details';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }
}

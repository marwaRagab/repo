<?php

namespace App\Repositories\Installment;

use App\Models\Installment;
use App\Models\Eqrars_details;
use App\Models\Paperstype;
use App\Models\Client;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class PapersInstallRepository
{
    public function getAllCounters()
    {
        return [
            'not_finished' => Eqrars_details::where('paper_received_checked', 0)->count(),
            'received' => Eqrars_details::where('paper_received_checked', 1)->count(),
            'tadqeeq' => Installment::with(['client', 'paper','eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'my_index');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1);
                })
                ->where('type', 'installment')
                ->where('tadqeeq', 1)
                ->where('manage_review', 0)
                ->where('status', 'finished')->count(),
            'manage_review' => Installment::with(['client', 'paper', 'eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'tadqeeq');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1);
                })
                ->where('type', 'installment')
                ->where('tadqeeq', 1)
                ->where('manage_review', 1)
                ->where('status', 'finished')
                ->where('tadqeeq_archive', 0)->count(),
            'archive' => Installment::with(['client', 'paper', 'eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'manage_review');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1)->where('paper_received', 1);
                })
                ->where('type', 'installment')
                ->where('status', 'finished')
                ->where('tadqeeq', 1)
                ->where('manage_review', 1)
                ->where('tadqeeq_archive', 1)
                ->where('archive_finished', 0)->count(),
            'archive_finished' => Installment::with(['client', 'paper', 'eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'manage_review');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1)->where('paper_received', 1);
                })
                ->where('type', 'installment')
                ->where('status', 'finished')
                ->where('tadqeeq', 1)
                ->where('manage_review', 1)
                ->where('tadqeeq_archive', 1)
                ->where('archive_finished', 1)
                ->where('archive_received', 0)->count(),
            'eqrar_dain' => 0,
            'eqrar_dain_recieved' => 0,
            'archive_received'=> 0
        ];
    }

    public function getPapersTypeWithStyles($papers_type, $all_counters)
    {
        $color_array = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger',
            'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', 'me-1 mb-1  bg-warning-subtle text-warning',
            'bg-warning-subtle text-warning', 'px-4 bg-primary-subtle text-primary', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger'];

        foreach ($papers_type as $key => $paper_type) {
            $papers_type[$key]->style = $color_array[array_rand($color_array)];
            $papers_type[$key]->count = $all_counters[$papers_type[$key]->slug];
        }

        return $papers_type;
    }

    public function getIndexData($status)
    {
        $title = 'المحفوظات';
        $all_counters = $this->getAllCounters();
        $papers = [];
        $papers_type = PapersType::all();
        $papers_type = $this->getPapersTypeWithStyles($papers_type, $all_counters);

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';
        $data['view'] = 'installment.papers.index';

        return compact('breadcrumb', 'papers', 'title', 'all_counters', 'papers_type', 'status', 'data');
    }

    public function addToInstallmentPapers($slug, $id, $data)
    {
        $adminId = Session::get('admin')['id'];
        $installment = Installment::findOrFail($id);
        $client = Client::findOrFail($installment->client_id);
        $admins = Admin::where('active', 1)->get();

        $addData = [];

        switch ($slug) {
            case 'not_finished':
                $addData['paper_received'] = 1;
                $noteTypeName = 'المعاملات الغير مستلمة';
                break;
            case 'my_index':
                $addData['paper_received_checked'] = 1;
                $noteTypeName = 'المعاملات مستلمة';
                $addData['tadqeeq'] = 1;
                break;
            case 'tadqeeq':
                $addData['tadqeeq'] = 1;
                $addData['manage_review'] = 1;
                $noteTypeName = 'التدقيق';
                break;
            case 'manage_review':
                $addData['manage_review'] = 1;
                $addData['tadqeeq_archive'] = 1;
                $noteTypeName = 'الإدارة';
                break;
            case 'archive':
                $addData['archive_final'] = 1;
                $noteTypeName = 'تسليم المحفوظات';
                break;
            case 'archive_finished':
                $addData['archive_received'] = 1;
                $noteTypeName = 'المحفوظات';
                break;
            case 'archive_received':
                $addData['archive_final'] = 1;
                $noteTypeName = 'تسليم الأرشيف';
                break;
            default:
                break;
        }

        $installment->update($addData);

        $paperData = [
            'installment_id' => $id,
            'slug' => $slug,
            'sender_id' => $adminId,
            'received_id' => $data['received_user_id'],
            'note' => $data['paper_received_note'],
            'date' => now(),
        ];

        if (isset($data['cinet_img'])) {
            $file = $data['cinet_img'];
            $path = $file->store('uploads/new_photos', 'public');
            $paperData['img_dir'] = $path;
        }

        Eqrars_details::create($paperData);

        // Update the notes (assuming you have a method for this)
        $this->updateTheNotes($id, $data['received_user_id'], $noteTypeName, $data['paper_received_note']);

        return compact('installment', 'client', 'admins', 'slug');
    }

    protected function updateTheNotes($id, $receivedId, $noteTypeName, $note)
    {
        // Implement the logic to update the notes
    }
}

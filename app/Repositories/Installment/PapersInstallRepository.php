<?php

namespace App\Repositories\Installment;

use App\Models\Installment;
use App\Models\InstallmentPaper;
use App\Models\Eqrars_details;
use App\Models\Paperstype;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\InstallmentNote;

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
        /*
        table->eqrars_details

        $addData = [
            'paper_eqrar_dain_received' => $data['paper_eqrar_dain_received'] ?? null,
            'paper_received_img' => $data['paper_received_img'] ?? null,
            'please_cancel_eqrar_dain' => $data['please_cancel_eqrar_dain'] ?? null,
            'paper_received_checked' => $data['paper_received_checked'] ?? null,
            'paper_received_note' => $data['paper_received_note'] ?? null,
            'paper_eqrar_dain_received_img' => $data['paper_eqrar_dain_received_img'] ?? null,
            'paper_received' => $data['paper_received'] ?? null,
            'cancel_eqrar_dain' => $data['cancel_eqrar_dain'] ?? null,
            'eqrar_dain_cancel_img' => $data['eqrar_dain_cancel_img'] ?? null,
            'paper_received_checked_date' => $data['paper_received_checked_date'] ?? null,
            'paper_eqrar_dain_received_date' => $data['paper_eqrar_dain_received_date'] ?? null,
            'paper_received_date' => $data['paper_received_date'] ?? null,
            'cancel_eqrar_dain_date' => $data['cancel_eqrar_dain_date'] ?? null,
            'paper_eqrar_dain_sender_id' => $data['paper_eqrar_dain_sender_id'] ?? null,
            'paper_eqrar_dain_received_user_id' => $data['paper_eqrar_dain_received_user_id'] ?? null,
            'paper_received_admin_id' => $data['paper_received_admin_id'] ?? null,
        ];
ALTER TABLE installment_papers
ADD COLUMN created_by BIGINT UNSIGNED NULL,
ADD COLUMN updated_by BIGINT UNSIGNED NULL,
ADD COLUMN created_at TIMESTAMP NULL,
ADD COLUMN updated_at TIMESTAMP NULL,
ADD COLUMN deleted_at TIMESTAMP NULL;

        ALTER TABLE installment_papers
ADD CONSTRAINT fk_created_by
FOREIGN KEY (created_by) REFERENCES users(id)
ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE installment_papers
ADD CONSTRAINT fk_updated_by
FOREIGN KEY (updated_by) REFERENCES users(id)
ON DELETE SET NULL ON UPDATE CASCADE;
         */

        $adminId = auth()->id() ?? null;
        $installment = Installment::with('client')->findOrFail($id);
        $eqrar = Eqrars_details::findOrFail($installment->eqrars_id);

        $client = $installment->client;
        $admins = User::where(['active' => '1', 'deleted_at' => null, 'type' => 'emp'])->get();

        $addData = [];
        $eqrarData = [];

        switch ($slug) {
            case 'not_finished':
                $eqrarData['paper_received'] = 1;
                $noteTypeName = 'المعاملات الغير مستلمة';
                break;
            case 'my_index':
                $eqrarData['paper_received_checked'] = 1;
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
        $eqrar->update($eqrarData);

        $paperData = [
            'installment_id' => $id,
            'slug' => $slug,
            'sender_id' => $adminId,
            'received_id' => $data['received_user_id'],
            'note' => $data['paper_received_note'],
            'date' => now(),
        ];

        if (isset($data['cinet_img'])) {

            $paperData['img_dir'] = $data['cinet_img'];
        }

        InstallmentPaper::create($paperData);

        // Update the notes (assuming you have a method for this)
        $this->updateTheNotes($id, $data['received_user_id'], $noteTypeName, $data['paper_received_note']);
        return true;

    }
    public function updateTheNotes($id, $receivedUserId, $noteTypeName, $note)
    {
        $adminData = auth()->user();
        $userFullName = $adminData->name_ar ;

        if ($noteTypeName == 'تسليم إقرار الدين') {
            $txt = 'إقرار الدين';
        } else {
            $txt = 'أوراق المعاملة';
        }

        $theNote = 'قسم الحفظ والتدقيق (' . $noteTypeName . '): <br> تسليم ' . $txt . ' إلى ' . $userFullName;

        if (!empty($note)) {
            $theNote .= ' <br> ملاحظة: <br> ' . $note;
        }

        $userId = auth()->id();
        $this->addInstallmentNote($id, $userId, $theNote, 'tadqeeq');
        return true;
    }

    protected function addInstallmentNote($id, $userId, $note, $type)
    {
        return InstallmentNote::create([
            'installment_clients_id' => $id,
            'created_by' => $userId,
            'note' => $note,
            'type' => $type,
        ]);
    }

}

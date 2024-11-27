<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\User;
use App\Models\Boker;
use App\Models\Region;
use App\Models\Ministry;
use App\Models\Governorate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Installment_Client extends Model
{
    use HasFactory;
     public $timestamps = false;

    protected $table = 'installment_clients';
    protected $fillable = [
        'installment_clients', 'cost_install', 'part', 'final_installment_amount',
        'count_months', 'count_months_without', 'status', 'total', 'monthly_amount',
        'cinet_installment', 'intrenal_installment', 'start_date', 'eqrar_dain', 
        'cinet_enter', 'amana_paper'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'area_id' ,'id');
    }
    public function ministry_working()
    {
        return $this->belongsTo(Ministry::class, 'ministry_id')->where('type','working');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    // public function Boker()
    // {
    //     return $this->belongsTo(Boker::class, 'boker_id');
    // }
    
     public function installmentBroker()
    {
        return $this->belongsTo(InstallmentBroker::class, 'boker_id');
    }
    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }
    public function installment_car()
    {
        return $this->hasMany(InstallmentCar::class,'installment_clients_id' ,'id');
    }
    public function installment_issue()
    {
        return $this->hasMany(InstallmentIssue::class,'installment_clients_id' ,'id');
    }
    public function installment_note()
    {
        return $this->hasMany(InstallmentClientNote::class,'installment_clients_id' ,'id');
    }
}

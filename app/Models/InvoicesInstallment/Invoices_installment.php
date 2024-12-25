<?php

namespace App\Models\InvoicesInstallment;

use DateTime;
use App\Models\Installment;
use App\Models\Installment_month;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoices_installment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "invoices_installment";

    public function installment()
    {
        return $this->belongsTo(Installment::class,'installment_id');
    }
    
    public function install_month()
    {
        return $this->belongsTo(Installment_month::class,'install_month_id');
    }


}

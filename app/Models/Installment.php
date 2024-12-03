<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Military_affairs\Military_affair;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Installment extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='installment';
    protected $guarded = [];



    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }
    public function client_old_data()
    {
        return $this->belongsTo(Prev_cols_clients::class,'client_id');

    }


    public function eqrar_not_recieve()
    {
        return $this->belongsTo(Eqrars_details::class,'eqrars_id')->where('paper_received',0);
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function installment_months()
    {
        return $this->hasMany(Installment_month::class,'installment_id');
    }
    public function militay_affairs()
    {
        return $this->belongsTo(Military_affair::class, 'installment_id')->where('status',0);
    }

    public function installment_client()
    {
        return $this->belongsTo(Installment_Client::class, 'installment_clients');
    }

    public function installment_eqrardain()
    {
        return $this->belongsTo(Eqrars_details::class, 'eqrars_id');
    }


    protected $appends = ['count'];

    public function getCountAttribute($status){
        return Installment_month::where(['installment_id'=>$this->id,'status' =>$status ,'installment_type' =>'installment'])->count();
    }

    public function get_total_amount($status)
    {
        if($this->months==36){
            return Installment_month::where(['installment_id'=>$this->id,'status' =>'not_done'])->where('installment_type', '!=','first_amount')->orwhere('installment_type', '!=','discount')->orwhere('installment_type', '!=','law_percent')->sum('amount');

        }
        return Installment_month::where(['installment_id'=>$this->id,'status' =>'not_done'])->where('installment_type', '!=','first_amount')->orwhere('installment_type', '!=','discount')->sum('amount');

    }
    public function count_installment_lated()
    {

        return Installment_month::where(['installment_id'=>$this->id,'status' =>'not_done', 'installment_type' =>'installment'])->where('date','<',date('Y-m-d'))->count();

    }

    // public function order()
    // {
    //     return Order::where(['client_id'=>$this->client_id])->get();
    // }

    // public function orders()
    // {
    //     // dd($this->belongsTo( Order::class, 'client_id', 'client_id'));
    //     return $this->belongsTo( Order::class, 'client_id', 'client_id');
    // }

    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id', 'client_id');
    }


}

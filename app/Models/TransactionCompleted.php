<?php

namespace App\Models;

use App\Models\CommuncationMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionCompleted extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions_completed';

    protected $fillable = [
        'name_ar',
        'name_en',
        'email',
        'whatsapp',
        'communcation_method_id',
        'Communication_method',
        'created_by',
        'updated_by'
    ];

    // Define any relationships here
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function communcation_method()
    // {
    //     $ids = explode(',', $this->Communication_method);
    //     // dd($this->Communication_method);
    //     return CommuncationMethod::whereIn('id', $ids)->get();

    // }
    public function communcation_method()
    {
        return $this->belongsTo(CommuncationMethod::class);
    }

    public function banks()
    {
        return $this->belongsTo(Bank::class);
    }

    public function courts()
    {
        return $this->belongsTo(Court::class);
    }
}

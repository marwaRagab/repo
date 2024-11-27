<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstallmentClientNote extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'reply',
        'note',
        'installment_clients_id',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

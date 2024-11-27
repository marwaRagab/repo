<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Boker extends Model
{
    use HasFactory;

    protected $table = 'installment_broker';  // Adjust the table name if necessary
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'boker_id');
    }

    public function installmentClient()
    {
        return $this->hasMany(Installment_Client::class, 'boker_id');
    }
}

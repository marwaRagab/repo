<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prev_cols_clients extends Model
{
    use HasFactory ;
    protected $guarded = [];
    protected $table ='prev_cols_clients';

    public function client_old()
    {

        return $this->belongsTo(Client::class, 'client_id');
    }




}

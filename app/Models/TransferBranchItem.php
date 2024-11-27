<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferBranchItem extends Model
{
    use HasFactory;

    protected $table = 'transfer_branches_itmes';
    public $timestamps = false;
}

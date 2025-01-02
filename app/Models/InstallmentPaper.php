<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentPaper extends Model
{
    use HasFactory;

    protected $fillable = [
        'installment_id', 'slug', 'date', 'note', 'img_dir', // Add other fields
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}

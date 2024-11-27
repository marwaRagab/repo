<?php

namespace App\Models\TechnicalSupport;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemReply extends Model
{
    use HasFactory;

    protected $table = 'prev_table_replay';
    const UPDATED_AT = null;
    protected $fillable = ['problem_id', 'descr', 'file', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

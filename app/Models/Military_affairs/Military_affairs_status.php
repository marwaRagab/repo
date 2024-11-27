<?php

namespace App\Models\Military_affairs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Military_affairs_status extends Model
{
    use HasFactory;
    protected $table = 'military_affairs_status';
    protected $guarded = [];
   /* protected $fillable = [
        'type','type_id','military_affairs_id','date'
    ];*/

    public function status()
    {
        return $this->belongsTo(Military_affair::class, 'military_affairs_id');
     }

}

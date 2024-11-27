<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';

    public function products()
{
    return $this->hasMany(Product::class, 'class_id'); // `mark_id` is the foreign key in the `products` table
}
}

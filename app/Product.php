<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'category_id',
        'name',
        'description',
        'price',
        'offer',
        'img',
        'updated_at'
    ];
}

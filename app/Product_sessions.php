<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_sessions extends Model
{
    public $table = 'product_sessions';
    protected $fillable = [
        'commerce_id',
        'user_id',
        'name',
        'updated_at',
        'is_deleted'
    ];
}

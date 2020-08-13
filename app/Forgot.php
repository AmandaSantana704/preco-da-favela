<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forgot extends Model
{
    public $table = 'user_forgot';
    protected $fillable = [
        'user_id',
        'token',
        'used',
        'created_at',
        'expires_at'
    ];

    public $timestamps = false;
}

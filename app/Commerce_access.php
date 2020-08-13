<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commerce_access extends Model
{
    protected $fillable = ['updated_at', 'is_deleted', 'commerce_id', 'user_id'];
    public $table = 'commerce_access';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'description',
        'operation',
        'telephone',
        'email',
        'instagram',
        'whatsapp',
        'location',
        'district',
        'logo',
        'cover',
        'updated_at',
        'lat',
        'lng',
        'is_deleted'
    ];
}

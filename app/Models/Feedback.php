<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'message',
        'created_at',
        'updated_at',
        'accepted'
    ];

    public $timestamps = true;
}

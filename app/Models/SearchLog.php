<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    protected $table = 'search_logs';

    protected $fillable = [
        'query',
        'user_agent',
        'created_at'
    ];

    protected $dates = ['created_at'];

    public $timestamps = false;
}

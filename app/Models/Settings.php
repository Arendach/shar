<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'name',
        'description',
        'section',
        'value',
        'size',
    ];

    public static function update_($fields)
    {
        $section = $fields->section;

        unset($fields->section);

        foreach ($fields as $k => $v) {
            DB::table('settings')
                ->where('section', '=', $section)
                ->where('name', '=', $k)
                ->update([
                    'value' => $v
                ]);
        }
    }
}

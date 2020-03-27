<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Settings
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $section
 * @property string $value
 * @property mixed $size
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereValue($value)
 * @mixin \Eloquent
 */
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

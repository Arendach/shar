<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $path_large
 * @property string $path_min
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage wherePathLarge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage wherePathMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereProductId($value)
 * @mixin \Eloquent
 */
class ProductImage extends Model
{
    public $timestamps = false;

    public function getPathMinAttribute($value)
    {
        if (is_file(public_path($value))) return asset($value);
        elseif (preg_match('/^http/', $value)) return $value;
        else return asset('images/no_photo.png');
    }

    public function getPathLargeAttribute($value)
    {
        if (is_file(public_path($value))) return asset($value);
        elseif (preg_match('/^http/', $value)) return $value;
        else return asset('images/no_photo.png');
    }
}

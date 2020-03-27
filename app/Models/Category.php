<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property int $archive
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $sort
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereArchive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withoutTrashed()
 * @mixin \Eloquent
 */
class Category extends Model
{
    use SoftDeletes;

    protected $table = 'category';

    protected $fillable = [
        'name',
        'description',
        'meta_keywords',
        'meta_description',
        'meta_title',
        'sort',
        'deleted_at'
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    public static function archive()
    {
        return DB::table('category')->where('archive', 1)->get();
    }

    public static function create($post)
    {
        return DB::table('category')->insertGetId([
            'name' => $post->name,
            'description' => $post->description,
            'meta_keywords' => $post->meta_keywords,
            'meta_description' => $post->meta_description,
            'meta_title' => $post->meta_title,
            'archive' => 0
        ]);
    }

    public static function update_category($post)
    {
        return DB::table('category')
            ->where('id', $post->id)
            ->update([
                'name' => $post->name,
                'description' => $post->description,
                'meta_keywords' => $post->meta_keywords,
                'meta_title' => $post->meta_title,
                'meta_description' => $post->meta_description,
                'sort' => $post->sort
            ]);
    }

    public function delete()
    {
        Product::where('category_id', $this->id)->delete();

        parent::delete();
    }

    public static function un_archive($id)
    {
        DB::table('category')
            ->where('id', $id)
            ->update(['archive' => 0]);

        DB::table('product')
            ->where('category_id', $id)
            ->update(['archive' => 0]);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')
            ->where('public', 1)
            ->limit(settings('main.items_to_category'));
    }

    public function allProducts()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')
            ->where('public', 1);
    }
}

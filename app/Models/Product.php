<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'product';

    protected $dates = ['updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'price',
        'category_id',
        'photo',
        'photo_min',
        'photo_description',
        'on_storage',
        'short',
        'description',
        'public',
        'articul',
        'deleted_at'
    ];

    use SoftDeletes;

    public function getUrlAttribute()
    {
        return route('product', $this->id);
    }

    public static function get_products_to_index()
    {
        $categories = DB::table('category')->where('archive', 0)->orderBy('sort', 'desc')->get();
        $categories = map_by($categories, 'id', 'object');

        foreach ($categories as $id => $item) {
            $categories->{$id}->items = DB::table('product')
                ->where('category_id', '=', $id)
                ->where('archive', 0)
                ->where('public', 1)
                ->limit(settings('main.items_to_category'))
                ->get();

            foreach ($categories->{$id}->items as $i => $item) {
                if (is_file(ROOT . $item->photo_min))
                    $categories->{$id}->items[$i]->photo = $item->photo_min;
                elseif (!is_file(ROOT . $item->photo))
                    $categories->{$id}->items[$i]->photo = '/public/images/no_photo.png';
            }

            $categories->{$id}->count = DB::table('product')
                ->where('category_id', '=', $id)
                ->where('archive', 0)
                ->where('public', 1)
                ->count();
        }

        return ($categories);
    }

    public static function get_items()
    {
        $builder = self::select('*');

        $builder->with('category');

        if (get('name'))
            $builder->where('name', 'like', '%' . get('name') . '%');

        if (get('articul'))
            $builder->where('articul', 'like', '%' . get('articul') . '%');

        if (get('price'))
            $builder->where('price', 'like', '%' . get('price') . '%');

        if (get('category'))
            $builder->where('category_id', get('category'));

        if (isset($_GET['on_storage']))
            $builder->where('on_storage', get('on_storage'));


        $result = $builder->paginate(config('app.items'));

        if (get('name'))
            $result->appends(['name' => get('name')]);

        if (get('articul'))
            $result->appends(['articul' => get('articul')]);

        if (get('price'))
            $result->appends(['price' => get('price')]);

        if (get('category'))
            $result->appends(['category' => get('category')]);

        if (isset($_GET['on_storage']))
            $result->appends(['on_storage' => get('on_storage')]);

        return $result;

    }

    public static function create($post)
    {
        return DB::table('product')->insertGetId([
            'name'             => $post->name,
            'meta_description' => '',
            'meta_keywords'    => '',
            'meta_title'       => '',
            'price'            => $post->price,
            'articul'          => $post->articul,
            'category_id'      => $post->category_id,
            'photo'            => '',
            'on_storage'       => '0',
            'description'      => $post->description,
            'short'            => $post->short,
            'public'           => 0,
            'archive'          => 0,
        ]);
    }

    public static function update_main($post)
    {
        DB::table('product')
            ->where('id', $post->id)
            ->update([
                'name'        => $post->name,
                'price'       => $post->price,
                'articul'     => $post->articul,
                'short'       => $post->short,
                'category_id' => $post->category_id,
                'description' => $post->description
            ]);
    }

    public static function update_other($post)
    {
        DB::table('product')
            ->where('id', $post->id)
            ->update([
                'meta_description' => $post->meta_description,
                'meta_keywords'    => $post->meta_keywords,
                'meta_title'       => $post->meta_title,
                'on_storage'       => $post->on_storage,
                'public'           => $post->public,
            ]);
    }

    public static function update_photo($post, $photo, $photo_min)
    {
        $bean = self::findOrFail($post->id);

        if (is_file($bean->photo)) {
            unlink(ROOT . $bean->photo);
        }

        if (is_file($bean->photo_min)) {
            unlink(ROOT . $bean->photo_min);
        }

        DB::table('product')
            ->where('id', $post->id)
            ->update([
                'photo'             => $photo,
                'photo_min'         => $photo_min,
                'photo_description' => $post->description
            ]);
    }

    public static function get_cart_products()
    {
        $products = DB::table('product')
            ->whereIn('id', get_keys($_COOKIE['cart_products']))
            ->get();

        return $products;

    }

    public static function add_photo($post, $path, $path_min)
    {
        DB::table('product_images')
            ->insert([
                'path_large'  => $path,
                'path_min'    => $path_min,
                'description' => $post->description,
                'product_id'  => $post->id
            ]);
    }

    public function getPhotoAttribute($value)
    {
        if (is_file(public_path($value))) return asset($value);
        elseif (preg_match('/^http/', $value)) return $value;
        else return asset('images/no_photo.png');
    }

    public function getPhotoMinAttribute($value)
    {
        if (is_file(public_path($value))) return asset($value);
        elseif (preg_match('/^http/', $value)) return $value;
        else return asset('images/no_photo.png');
    }

    public function getLazyAttribute()
    {
        return asset('images/balloons.jpg');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}

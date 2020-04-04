<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        'deleted_at',
        'slug'
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    public static function archive()
    {
        return DB::table('category')->where('archive', 1)->get();
    }

    public static function update_category($post)
    {
        return DB::table('category')
            ->where('id', $post->id)
            ->update([
                'name'             => $post->name,
                'description'      => $post->description,
                'meta_keywords'    => $post->meta_keywords,
                'meta_title'       => $post->meta_title,
                'meta_description' => $post->meta_description,
                'sort'             => $post->sort
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
            ->where('public', 1);
    }

    public function getUrlAttribute()
    {
        return route('category', $this->slug);
    }
}

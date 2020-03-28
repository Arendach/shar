<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySluggable extends Seeder
{
    public function run()
    {
        Category::withTrashed()->get()->each(function (Category $category) {
            $category->slug = \Illuminate\Support\Str::slug($category->name . '-' . $category->id);
            $category->save();
        });
    }
}

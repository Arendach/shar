<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::with(['products' => function (Builder $builder) {
            $builder->orderByDesc('priority');
        }])->where('slug', $slug)->firstOrFail();

        $data = [
            'title'            => $category->meta_title,
            'meta_keywords'    => $category->meta_keywords,
            'meta_description' => $category->meta_description,
            'category'         => $category,
            'breadcrumbs'      => [[$category->name]],
        ];

        return view('category.main', $data);
    }
}

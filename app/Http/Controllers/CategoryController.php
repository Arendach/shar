<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{

    public function section_main()
    {
        abort_if(!get('id'), 404);

        $category = Category::with('allProducts')->findOrFail(get('id'));

        $data = [
            'title' => $category->meta_title,
            'meta_keywords' => $category->meta_keywords,
            'meta_description' => $category->meta_description,
            'category' => $category,
            'css' => ['category'],
            'breadcrumbs' => [[$category->name]],
        ];

        return view('category.main', $data);
    }
}

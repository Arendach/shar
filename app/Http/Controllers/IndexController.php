<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class IndexController extends Controller
{
    public function section_main()
    {
        $items = Category::orderBy('sort', 'desc')->get();

        $items->each(function (Category $item){
            $item->load('products');

            $item->countProducts = Product::where('category_id', $item->id)->count();

            return $item;
        });

        $data = [
            'title' => settings('seo.title', 'Доставка шаров'),
            'categories' => Category::all(),
            'items' => $items,
            'components' => ['sweetalert'],
            'css' => ['category'],
            'meta_keywords' => settings('seo.meta_keywords'),
            'meta_description' => settings('seo.meta_description'),
        ];

        return view('pages.index', $data);
    }
}

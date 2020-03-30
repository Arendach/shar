<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gumlet\ImageResize;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('images', 'category')
            ->where('id', $id)
            ->where('public', 1)
            ->firstOrFail();

        $data = [
            'title'            => $product->meta_title,
            'meta_description' => $product->meta_description,
            'meta_keywords'    => $product->meta_keywords,
            'product'          => $product,
            'breadcrumbs'      => [
                [$product->category->name, $product->category->url],
                [$product->name]
            ]
        ];

        return view('product.main', $data);
    }
}

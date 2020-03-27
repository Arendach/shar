<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class NormController extends Controller
{
    public function index()
    {
        // $this->product_images();
        // $this->categories();
        // $this->product();
    }

    private function product_images()
    {
        $images = ProductImage::all();

        foreach ($images as $image) {
            $image->path_min = preg_replace('/^\/public/', '', $image->getOriginal('path_min'));
            $image->path_large = preg_replace('/^\/public/', '', $image->getOriginal('path_large'));

            $image->save();
        }
    }

    private function categories()
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            if ($category->archive) $category->deleted_at = date('Y-m-d H:i:s');

            $category->save();
        }
    }

    private function product()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $product->photo = preg_replace('/^\/public/', '', $product->getOriginal('photo'));
            $product->photo_min = preg_replace('/^\/public/', '', $product->getOriginal('photo_min'));

            if ($product->archive) $product->deleted_at = date('Y-m-d H:i:s');

            $product->save();
        }
    }
}

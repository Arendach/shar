<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gumlet\ImageResize;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('images', 'category')->where('public', 1)->firstOrFail($id);

        $data = [
            'title'            => $product->meta_title,
            'meta_description' => $product->meta_description,
            'meta_keywords'    => $product->meta_keywords,
            'breadcrumbs'      => [
                [$product->category->name, uri('category', ['id' => $product->category->id])],
                [$product->name]
            ],
            'product'          => $product
        ];

        return view('product.main', $data);
    }

    public function section_create_pics()
    {
        $products = Product::where('photo_min', '')->where('photo', '!=', '')->get();

        $i = 0;
        foreach ($products as $product) {
            $path = '/public/photos/' . $product->id . '/';
            $path_min = $path . 'min/';

            create_folder_if_not_exists($path);
            create_folder_if_not_exists($path_min);

            $extension = mb_strtolower(pathinfo($product->photo)['extension']);
            $name = rand32() . '.' . $extension;

            $product->photo = preg_replace('@^\/@', '', $product->photo);

            if (is_file(ROOT . $product->photo)) {
                // copy
                copy(ROOT . $product->photo, ROOT . $path . $name);

                $image = new ImageResize(ROOT . $path . $name);
                $image->resizeToWidth(500);
                $image->save(ROOT . $path_min . $name);

                unlink(ROOT . $product->photo);

                $product->photo = $path . $name;
                $product->photo_min = $path_min . $name;

                $product->save();
            }

            echo $i . '<br>';
        }
    }
}

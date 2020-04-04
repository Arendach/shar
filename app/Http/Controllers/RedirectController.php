<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class RedirectController extends Controller
{
    public function product()
    {
        abort_if(!request()->has('id'), 404);

        $product = Product::findOrFail(request('id'));

        return redirect($product->url);
    }

    public function category()
    {
        abort_if(!request()->has('id'), 404);

        $category = Category::findOrFail(request('id'));

        return redirect($category->url);
    }

    public function feedback($id)
    {
        return redirect()->to("admin/feedback/$id");
    }
}

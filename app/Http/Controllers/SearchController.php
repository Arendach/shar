<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SearchController extends Controller
{

    public function index($query = '')
    {
        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('articul', 'like', "%$query%")
            ->paginate(config('app.items'));

        $data = [
            'title' => 'Поиск по сайту',
            'search_query' => $query,
            'products' => $products,
            'css' => ['category'],
            'breadcrumbs' => [
                ["Поиск по сайту - $query"]
            ]
        ];

        return view('search.main', $data);
    }
}

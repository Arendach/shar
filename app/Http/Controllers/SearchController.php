<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SearchLog;

class SearchController extends Controller
{

    public function index($query = '')
    {
        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "$query")
            ->orWhere('articul', 'like', "%$query%")
            ->orderByDesc('priority')
            ->paginate(24)
            ->onEachSide(2);

        $this->log($query);

        $data = [
            'title'        => 'Поиск по сайту',
            'search_query' => $query,
            'products'     => $products,
            'breadcrumbs'  => [["Поиск по запросу - <b>$query</b>"]]
        ];

        return view('search.main', $data);
    }

    private function log(string $query): void
    {
        SearchLog::create([
            'query'      => $query,
            'user_agent' => request()->userAgent(),
            'created_at' => now()
        ]);
    }
}

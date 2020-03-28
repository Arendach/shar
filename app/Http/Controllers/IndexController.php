<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndexController extends Controller
{
    public function section_main()
    {
        $items = Category::withCount('allProducts')->orderByDesc('sort')->get();

        $items->each(function (Category $category) {
            $category->load(['products' => function (HasMany $builder) {
                $builder->limit(settings('main.items_to_category'));
            }]);
        });

        $data = [
            'title'            => settings('seo.title', 'Доставка шаров'),
            'items'            => $items,
            'meta_keywords'    => settings('seo.meta_keywords'),
            'meta_description' => settings('seo.meta_description'),
        ];

        return view('pages.index', $data);
    }
}

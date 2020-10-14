<?php


namespace App\Http\Composers;

use App\Models\Category;
use Illuminate\View\View;

class MainComposer
{
    public function compose(View $view)
    {
        $categories = \Cache::rememberForever('categoriesInMainComposer', function () {
            return Category::withCount('products')->orderByDesc('sort')->get();
        });

        return $view->with(compact('categories'));
    }
}
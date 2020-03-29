<?php


namespace App\Http\Composers;

use App\Models\Category;
use Illuminate\View\View;

class MainComposer
{
    public function compose(View $view)
    {
        return $view->with('categories', Category::withCount('products')->get());
    }
}
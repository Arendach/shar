<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SiteMapController extends Controller
{
    /** @var $map  Sitemap */
    private $map;

    public function index()
    {
        $this->map = Sitemap::create();

        $this->mainPage();

        $this->categoryPages();

        $this->productPages();

        $map = $this->map->render();

        return response($map, 200)->header('Content-Type', 'application/xml');
    }

    private function mainPage()
    {
        $url = Url::create('/')
            ->setLastModificationDate(Carbon::now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(1.0);

        $this->map->add($url);
    }

    private function categoryPages()
    {
        Category::all()->each(function (Category $category) {
            $url = Url::create($category->url)
                ->setLastModificationDate(
                    !is_null($category->updated_at) ? $category->updated_at : Carbon::now()
                )
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.9);

            $this->map->add($url);
        });
    }

    private function productPages()
    {
        Product::all()->each(function (Product $product) {
            $url = Url::create($product->url)
                ->setLastModificationDate(
                    !is_null($product->updated_at) ? $product->updated_at : Carbon::now()
                )
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8);

            $this->map->add($url);
        });
    }
}

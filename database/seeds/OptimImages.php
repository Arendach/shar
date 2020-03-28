<?php

use App\Models\Product;
use Gumlet\ImageResize;
use Illuminate\Database\Seeder;

class OptimImages extends Seeder
{
    public function run()
    {
        Product::all()->each(function (Product $product) {
            if (preg_match('~\.png$~i', $product->getOriginal('photo'))) {
                $this->PNGtoJPG($product);
            }

            $this->optimizationImage($product);
        });
    }

    private function PNGtoJPG(Product &$product): void
    {
        $rand = rand(1000, 9999);

        try {
            $path = $product->getOriginal('photo');
            $jpgPath = preg_replace('~\.png$~i', "$rand.jpg", $path);

            $image = imagecreatefrompng(public_path($path));
            imagejpeg($image, public_path($jpgPath));
            imagedestroy($image);

            $product->update([
                'photo' => $jpgPath
            ]);
        } catch (Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }

    private function optimizationImage(Product &$product): void
    {
        try {
            [$width, $height] = getimagesize(public_path($product->getOriginal('photo')));

            $orientation = $width > $height ? 'landscape' : 'portrait';

            $name = $product->getOriginal('photo');
            $name = basename($name);

            $image = new ImageResize(public_path($product->getOriginal('photo')));

            if ($orientation == 'portrait') {
                $image->resizeToWidth(400);
            } else {
                $image->resizeToHeight(400);
            }

            $image->save(public_path("photos/{$product->id}/min/$name"));

            $product->update([
                'photo_min' => "photos/{$product->id}/min/$name"
            ]);
        } catch (Exception $exception) {
            $this->command->warn($exception->getMessage());
        }
    }
}

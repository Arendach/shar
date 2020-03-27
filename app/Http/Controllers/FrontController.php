<?php

namespace App\Http\Controllers;

class FrontController
{
    public function scripts()
    {
        $files = [
            '/public/js/jquery.js',
            '/public/js/popper.js',
            '/public/js/bootstrap.js',
            '/public/js/functions.js',
            '/public/js/custom.js',
            '/public/js/jquery.serialize_json.js',
            '/public/js/jquery.input_mask.js',
            '/public/js/sweetalert/sweetalert.js',
            '/public/js/sweetalert/sweetalert_functions.js',
            '/public/js/modules/cart.js',
            '/public/js/jquery.cookie.js',
        ];

        $content = '';
        foreach ($files as $file) {
            $minify = file_get_contents(base_path($file));
            $minify = preg_replace('[\s]+', ' ', $minify);
            $content .= $minify;
        }

        return response($content, 200)
            ->header('Content-Type', 'text/javascript');
    }
}
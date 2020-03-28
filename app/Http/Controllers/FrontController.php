<?php

namespace App\Http\Controllers;

use Agent;
use Tholu\Packer\Packer;

class FrontController
{
    public function scripts()
    {
        $files = [
            '/public/js/jquery.js',
            '/public/js/popper.js',
            '/public/js/bootstrap.js',
            '/public/js/components/gallery/photoswipe.min.js',
            '/public/js/components/gallery/photoswipe-ui-default.min.js',
            '/public/js/functions.js',
            '/public/js/custom.js',
            '/public/js/jquery.serialize_json.js',
            '/public/js/jquery.input_mask.js',
            '/public/js/components/sweetalert/sweetalert.js',
            '/public/js/components/sweetalert/sweetalert_functions.js',
            '/public/js/modules/cart.js',
            '/public/js/jquery.cookie.js',
        ];

        if (Agent::isDesktop()) {
            $files[] = '/public/js/desktop.js';
        }

        $content = '';
        foreach ($files as $file) {
            $content .= file_get_contents(base_path($file));
        }

       // $content =  (new Packer($content, 0))->pack();

        return response($content, 200)
            ->header('Content-Type', 'text/javascript');
    }
}
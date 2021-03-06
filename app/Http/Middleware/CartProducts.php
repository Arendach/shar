<?php

namespace App\Http\Middleware;

use Closure;

class CartProducts
{
    public function handle($request, Closure $next)
    {
        if (isset($_COOKIE['cart_products'])) {
            $_COOKIE['cart_products'] = json_decode($_COOKIE['cart_products']);
            $_SESSION['cart_products'] = $_COOKIE['cart_products'];
        } else {
            $_COOKIE['cart_products'] = (object)[];
            $_SESSION['cart_products'] = (object)[];
        }

        return $next($request);
    }
}

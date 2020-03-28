<?php

namespace App\Providers;

use App\Http\Composers\MainComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('layouts.main', MainComposer::class);
    }
}

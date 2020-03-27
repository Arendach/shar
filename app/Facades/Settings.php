<?php


namespace App\Facades;


use App\Services\SettingsService;
use Illuminate\Support\Facades\Facade;

class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingsService::class;
    }
}

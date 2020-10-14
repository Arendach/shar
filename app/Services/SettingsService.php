<?php

namespace App\Services;

use App\Models\Settings;

class SettingsService
{
    /**
     * @var array
     */
    private $container = [];

    public function __construct()
    {
        $this->boot();
    }

    private function boot(): void
    {
        $result = \Cache::rememberForever('settings', function () {
            return Settings::all();
        });

        if ($result->count() > 0) {
            $temp = [];
            foreach ($result as $item) {
                if (!isset($temp[$item->section]))
                    $temp[$item->section] = [];

                $temp[$item->section][$item->name] = [
                    'id'          => $item->id,
                    'value'       => $item->value,
                    'description' => $item->description,
                    'size'        => $item->size
                ];
            }

            $this->container = ($temp);
        } else {
            $this->container = [];
        }
    }

    public function all(): array
    {
        return $this->container;
    }

    public function get(string $key, $default = '')
    {
        list($section, $key) = explode('.', $key);

        if (!isset($this->container[$section][$key])) return $default;
        else return $this->container[$section][$key]['value'];
    }

    public function getSection($section)
    {
        return isset($this->container[$section]) ? $this->container[$section] : [];
    }
}

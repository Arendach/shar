<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function section_main()
    {
        $data = [
            'title' => 'Главная панель'
        ];

        return view('admin.index', $data);
    }
}

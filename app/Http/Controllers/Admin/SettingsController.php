<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function section_main()
    {
        $data = [
            'title' => 'Настройки',
            'js' => [
                asset('ckeditor/ckeditor.js')
            ],
            'components' => ['serializejson', 'sweetalert'],
            'breadcrumb' => [['name' => 'Настройки']]
        ];

        return view('admin.settings.main', $data);
    }

    public function action_update($post)
    {
        Settings::update_($post);

        \Artisan::call('cache:clear');

        res(200, 'Данные успешно оновлено!');
    }

    public function action_update_photo()
    {
        if (!is_dir(public_path('images')))
            mkdir(public_path('images'), 0777, true);

        $ext = mb_strtolower(pathinfo($_FILES['file']['name'])['extension']);
        $name = "background.$ext";

        if (move_uploaded_file($_FILES['file']['tmp_name'], public_path("images/$name"))) {
            DB::table('settings')
                ->where('section', 'layer')
                ->where('name', 'image')
                ->update(['value' => "images/$name"]);

            \Artisan::call('cache:clear');

            res(200, 'Фото успешно обновлено!');
        } else {
            \Artisan::call('cache:clear');

            res(500, 'Не удалось загрузить изображение!');
        }
    }
}

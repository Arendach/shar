<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function section_main()
    {
        $data = [
            'title' => 'Категории',
            'breadcrumb' => [['name' => 'Категории']],
            'categories' => Category::all(),
            'js' => [asset('admin_files/js/category.js')],
            'components' => ['sweetalert', 'serializejson']
        ];

        return view('admin.category.main', $data);
    }

    public function section_update()
    {
        if (!get('id')) $this->display_404();

        $data = [
            'title' => 'Редактирование категории',
            'category' => Category::findOrFail(get('id')),
            'breadcrumb' => [['name' => 'Категории', 'url' => 'admin/category'], ['name' => 'Редактирование']],
            'components' => ['serializejson', 'sweetalert'],
            'js' => [asset('admin_files/js/category.js')]
        ];

        if (get('notification') == 'created') {
            $data['notification'] = ['message' => 'Категория успешно создана!'];
        }
        return view('admin.category.update', $data);
    }

    public function section_create()
    {
        $data = [
            'title' => 'Новая категория',
            'breadcrumb' => [['name' => 'Категории', 'url' => 'admin/category'], ['name' => 'Создание']],
            'components' => ['serializejson', 'sweetalert'],
            'js' => [asset('admin_files/js/category.js')]
        ];

        return view('admin.category.create', $data);
    }

    public function section_archive()
    {
        $data = [
            'title' => 'Архив категорий',
            'breadcrumb' => [['name' => 'Категории', 'url' => 'admin/category'], ['name' => 'Архив']],
            'components' => ['serializejson', 'sweetalert'],
            'js' => [asset('admin_files/js/category.js')],
            'categories' => Category::onlyTrashed()->get()
        ];

        return view('admin.category.archive', $data);
    }

    public function action_update($post)
    {
        if (empty($post->name)) res(400, 'Заполните имя!');
        if (empty($post->description)) res(400, 'Заполните описание!');

        Category::update_category($post);

        res(200, 'Данные успешно оновлены!');
    }

    public function action_create($post)
    {
        if (empty($post->name)) res(400, 'Заполните имя!');
        if (empty($post->description)) res(400, 'Заполните описание!');

        $id = Category::create($post);

        if ($id) res(200, ['id' => $id]);
        else res(400, 'Фатальная ошибка!');
    }

    public function action_to_archive($post)
    {
        Category::findOrFail($post->id)
            ->delete();

        res(200, 'Категория успешно переведена в архив!');
    }

    public function action_un_archive($post)
    {
        Category::withTrashed()
            ->findOrFail($post->id)
            ->update(['deleted_at' => null]);

        Product::withTrashed()
            ->where('category_id', $post->id)
            ->update(['deleted_at' => null]);

        res(200, 'Категория успешно переведена из архива!');
    }
}

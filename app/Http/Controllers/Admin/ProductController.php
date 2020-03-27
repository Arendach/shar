<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Gumlet\ImageResize;
class ProductController extends Controller
{
    public function section_main()
    {

        $data = [
            'items' => Product::get_items(),
            'title' => 'Товары',
            'breadcrumb' => [['name' => 'Товары']],
            'categories' => Category::all()
        ];

        return view('admin.product.main', $data);
    }

    public function section_create()
    {
        $data = [
            'title' => 'Новый товар',
            'breadcrumb' => [['name' => 'Товары', 'url' => 'admin/product'], ['name' => 'Новый товар']],
            'categories' => Category::all(),
            'js' => [
                asset('ckeditor/ckeditor.js'),
                asset('admin_files/js/product.js'),
            ],
            'components' => ['sweetalert', 'serializejson']
        ];

        return view('admin.product.create', $data);
    }

    public function section_update()
    {
        abort_if(!get('id'), 404);

        $data = [
            'title' => 'Редактирование товара',
            'breadcrumb' => [['name' => 'Товары', 'url' => 'admin/product'], ['name' => 'Редактирование']],
            'categories' => Category::all(),
            'product' => Product::with('images')->findOrFail(get('id')),
            'js' => [
                asset('ckeditor/ckeditor.js'),
                asset('admin_files/js/product.js'),
            ],
            'components' => ['sweetalert', 'serializejson', 'modal']

        ];

        if (get('notification') == 'created') {
            $data['notification'] = [
                'title' => 'Выполнено!',
                'message' => 'Товар успешно создан!',
                'type' => 'success'
            ];
        }

        return view('admin.product.update', $data);
    }


    public function action_create($post)
    {
        if (empty($post->name)) res(400, 'Заполните название!');
        if (empty($post->price)) res(400, 'Заполните цену!');
        if (empty($post->articul)) res(400, 'Заполните артикул!');

        $id = Product::create($post);

        if ($id) {
            res(200, ['message' => 'Товар создан успешно!', 'id' => $id]);
        } else {
            res(500, 'Товар не создан!');
        }
    }

    public function action_update_main($post)
    {
        if (empty($post->name)) res(400, 'Заполните название!');
        if (empty($post->price)) res(400, 'Заполните цену!');
        if (empty($post->articul)) res(400, 'Заполните артикул!');

        Product::update_main($post);

        res(200, 'Товар успешно обновлен!');
    }

    public function action_update_other($post)
    {
        if (empty($post->meta_title)) res(400, 'Заполните заголовок товара!');

        Product::update_other($post);

        res(200, 'Товар успешно обновлен!');
    }

    public function action_update_photo($post)
    {
        $path = "photos/{$post->id}";
        $path_min = "$path/min";

        if (!is_dir(public_path($path)))
            mkdir(public_path($path));

        if (!is_dir(public_path($path_min)))
            mkdir(public_path($path_min));

        $extension = mb_strtolower(pathinfo($_FILES['file']['name'])['extension']);
        $name = rand32() . '.' . $extension;

        if (move_uploaded_file($_FILES['file']['tmp_name'], public_path("$path/$name"))) {

            $image = new ImageResize(public_path("$path/$name"));
            $image->resizeToWidth(500);
            $image->save(public_path("$path_min/$name"));

            Product::update_photo($post, "$path/$name", "$path_min/$name");
            res(200, 'Фото успешно загружено!');
        } else {
            res(500, 'Не удалось загрузить изображение!');
        }
    }

    public function action_add_photo($post)
    {
        $path = "photos/{$post->id}";
        $path_min = "$path/min";

        if (!is_dir(public_path($path)))
            mkdir(public_path($path));

        if (!is_dir(public_path($path_min)))
            mkdir(public_path($path_min));

        $err = 0;
        $count = my_count($_FILES['files']['name']);

        foreach ($_FILES['files']['name'] as $it => $file_name) {
            $extension = mb_strtolower(pathinfo($file_name)['extension']);

            $name = rand32() . '.' . $extension;

            if (move_uploaded_file($_FILES['files']['tmp_name'][$it], public_path("$path/$name"))) {

                $image = new ImageResize(public_path("$path/$name"));
                $image->resizeToWidth(500);
                $image->save(public_path("$path_min/$name"));

                Product::add_photo($post, "$path/$name", "$path_min/$name");
            } else $err++;
        }

        $uploads = $count - $err;

        if ($err == $count)  res(200, "Ни один файл не был загружен!");
        else res(200, "Загружено {$uploads} из $count");
    }

    public function action_delete_photo($post)
    {
        $photo = ProductImage::findOrFail($post->id);

        unlink(public_path($photo->getOriginal('path_large')));
        unlink(public_path($photo->getOriginal('path_min')));

        $photo->delete();

        res(200, 'Фото успешно удалено');
    }

    public function action_update_photo_description_form($post)
    {
        $data = [
            'title' => 'Редактировать описание',
            'photo' => DB::table('product_images')->where('id', $post->id)->first()
        ];

        return view('admin.product.update_photo_description', $data);
    }

    public function action_update_photo_description($post)
    {
        DB::table('product_images')->where('id', $post->id)->update([
            'description' => $post->description
        ]);

        res(200, 'Описание успешно обновлено!');
    }

}

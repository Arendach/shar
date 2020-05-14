<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function action_login(AdminLoginRequest $request)
    {
        if (User::check_login($request)) {
            return response('Success');
        } else {
            return response()->json([
                'message' => 'Логин или пароль введено не верно!'
            ], 422);
        }
    }

    public function action_exit()
    {
        unset($_SESSION['user']);

        if (isset($_COOKIE['session'])) {
            User::sessionDestroy($_COOKIE['session']);
        }

        setcookie('session', '', time() - 1);

        header('Location: /');
    }

    public function section_main()
    {
        $data = [
            'title'      => 'Пользователи',
            'users'      => User::all(),
            'components' => ['modal', 'sweetalert', 'serializejson'],
            'access'     => User::get_access_all(),
            'breadcrumb' => [['name' => 'Пользователи']]
        ];

        return view('admin.users.main', $data);
    }

    public function action_register_form()
    {
        return view('admin.users.register_form', [
            'title'  => 'Новый пользователь',
            'access' => User::get_access_all()
        ]);
    }

    public function action_register(Request $post)
    {
        if ($post->password != $post->password_conf)
            res(400, 'Пароли не совпадают!');

        if (!my_count(User::where('login', $post->login)->get()))
            res(400, 'Логин занят! Выберите другой!');

        if (!preg_match('/[a-zA-Z0-9]{3,16}/', $post->login))
            res(400, 'Логин только латинские бувы и цыфры от 3 до 16 символо!');

        if (empty($post->name))
            res(400, 'Введите имя');

        if (mb_strlen($post->password) < 6 || mb_strlen($post->password) > 16)
            res(400, 'Пароль не может біть короче 6 и длиннее 16 символов!');

        User::register($post);

        res(200, 'Пользователь успешно зарегистрирован!');
    }

    public function action_update_form($post)
    {
        $data = [
            'title'  => 'Редактировать пользователя',
            'access' => User::get_access_all(),
            'user'   => User::findOrFail($post->id)
        ];

        return view('admin.users.update_form', $data);
    }

    public function action_update_info($post)
    {
        $user = User::where('id', $post->id)->first();

        if ($user->login != $post->login)
            if (!my_count(User::where('login', $post->login)->get()))
                res(400, 'Логин занят! Выберите другой!');

        if (!preg_match('/[a-zA-Z0-9]{3,16}/', $post->login))
            res(400, 'Логин только латинские бувы и цыфры от 3 до 16 символо!');

        if (empty($post->name))
            res(400, 'Введите имя');

        User::where('id', $post->id)->update([
            'login'  => $post->login,
            'name'   => $post->name,
            'access' => $post->access
        ]);

        res(200, 'Данные успешно оновлены!');
    }

    public function action_update_password($post)
    {
        if ($post->password != $post->password_conf)
            res(400, 'Пароли не совпадают!');

        if (mb_strlen($post->password) < 6 || mb_strlen($post->password) > 16)
            res(400, 'Пароль не может біть короче 6 и длиннее 16 символов!');

        User::where('id', $post->id)->update([
            'password' => my_crypt($post->password)
        ]);

        res(200, 'Данные успешно оновлены!');
    }

    public function action_delete($post)
    {
        User::where('id', $post->id)->delete();

        res(200, 'Пользователь удален!');
    }

    public function section_access()
    {
        $data = [
            'title'         => 'Настройки доступа',
            'users'         => User::all(),
            'components'    => ['modal', 'sweetalert', 'serializejson'],
            'access_groups' => User::get_access_all(),
            'breadcrumb'    => [['name' => 'Настройки доступа']]
        ];

        return view('admin.users.access', $data);
    }

    public function action_create_access_group_form()
    {
        return view('admin.users.create_access_group_form', [
            'title' => 'Новая группа доступа'
        ]);
    }

    public function action_update_access_group_form($post)
    {
        return view('admin.users.update_access_group_form', [
            'title'  => 'Редактировать группу доступа',
            'access' => DB::table('users_access')->where('id', $post->id)->first()
        ]);
    }

    public function action_create_access_group($post)
    {
        $name = $post->name;

        unset($post->name);

        DB::table('users_access')->insert([
            'name'  => $name,
            'array' => json_encode(get_keys($post))
        ]);

        res(200, 'Группа доступа успешно создана!');
    }

    public function action_update_access_group($post)
    {
        $name = $post->name;
        $id = $post->id;

        unset($post->name, $post->id);

        DB::table('users_access')->where('id', $id)->update([
            'name'  => $name,
            'array' => json_encode(get_keys($post))
        ]);

        res(200, 'Группа доступа успешно обновлена!');
    }

    public function action_delete_access_group($post)
    {
        DB::table('users_access')->where('id', $post->id)->delete();

        res(200, 'Группа доступа удалена!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Mobizon\MobizonApi;

class OrderController extends Controller
{
    public function action_create($post)
    {
        if (empty($post->name))
            res(400, 'Введите имя!');

        if (!preg_match('/[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}/', $post->phone))
            res(400, 'Введите номер телефона в правильном формате!');

        if (!isset($post->products) || empty($post->products))
            res(400, 'Выберите хотя-бы один товар для заказа!');

        $id = Order::create($post);

        $this->sms_notification($id);

        setcookie('cart_products', '', time() - 1);

        res(200, 'Ваш заказ успешно принято!Дождитесь звонка менеджера!');
    }

    public function sms_notification($id)
    {
        if (settings('sms.use') == 1)
            send_sms(settings('sms.number'), settings('sms.template'), 'Оповещеие об заказе №' . $id);
    }
}
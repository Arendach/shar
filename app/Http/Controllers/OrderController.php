<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        if (!$request->name) {
            return response()->json([
                'message' => 'Введите имя!'
            ], 400);
        }

        if (!preg_match('/[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}/', $request->phone)) {
            return response()->json([
                'Введите номер телефона в правильном формате!'
            ], 400);
        }

        if (!is_array($request->products) || count($request->products) == 0) {
            return response()->json([
                'Выберите хотя-бы один товар для заказа!'
            ], 400);
        }

        $id = Order::create($request);

        $this->sms_notification($id);

        setcookie('cart_products', '', time() - 99999, '/');

        return response()->json([
            'message' => 'Ваш заказ успешно принят! Дожидайтесь звонка менеджера!'
        ]);
    }

    public function sms_notification($id)
    {
        if (settings('sms.use') == 1) {
            send_sms(settings('sms.number'), settings('sms.template'), 'Оповещеие об заказе №' . $id);
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function section_main()
    {
        $data = [
            'title' => 'Заказы',
            'breadcrumb' => [['name' => 'Заказы']],
            'orders' => Order::with('user')->orderBy('id', 'desc')->paginate(config('app.items')),
            'components' => ['sweetalert']
        ];

        return view('admin.order.main', $data);
    }

    public function section_update()
    {
        abort_if(!get('id'), 404);

        $order = Order::with('products')
            ->findOrFail(get('id'));

        $data = [
            'title' => 'Редактирование заказа',
            'breadcrumb' => [['url' => 'admin/order', 'name' => 'Заказы'], ['name' => 'Редактирование']],
            'order' => $order
        ];

        return view('admin.order.update', $data);
    }

    public function action_accepted($post)
    {
        $order = Order::find($post->id);

        $order->accepted = user()->id;

        $order->save();

        res(200, 'Заказ успешно принят вами!');
    }
}

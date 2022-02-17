<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = [];
    protected $table = 'order';

    public static function get_all()
    {
        return DB::table('order')->orderBy('id', 'desc')->paginate(config('app.items'));
    }

    public static function create($post)
    {
        unset($post->_token);

        $id = DB::table('order')
            ->insertGetId([
                'name'          => $post->name,
                'phone'         => $post->phone,
                'comment'       => $post->comment,
                'created_at'    => date('Y-m-d H:i:s'),
                'date_delivery' => date('Y-m-d'),
                'sum'           => 0,
                'discount'      => 0,
                'delivery_cost' => 0
            ]);

        $sum = 0;
        foreach ($post->products as $product_id => $amount) {
            $product = DB::table('product')->where('id', '=', $product_id)->first();

            $sum += $product->price * $amount;

            DB::table('product_to_order')->insert([
                'order_id'   => $id,
                'product_id' => $product_id,
                'amount'     => $amount,
                'price'      => $product->price
            ]);
        }

        $order = Order::findOrFail($id);
        $order->update(['sum' => $sum]);

        return $order;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'accepted', 'id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id')
            ->with('product');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}

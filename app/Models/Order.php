<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $comment
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $date_delivery
 * @property float $sum
 * @property float $discount
 * @property float $delivery_cost
 * @property int|null $accepted
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDateDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeliveryCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    protected $table = 'order';

    public static function get_all()
    {
        return DB::table('order')->orderBy('id', 'desc')->paginate(config('app.items'));
    }

    /*public static function get_products($order_id)
    {
        $products = DB::table('product_to_order')
            ->select('product_to_order.*', 'product.name', 'product.photo', 'product.photo_min', 'category.name as category_name')
            ->leftJoin('product', 'product.id', '=', 'product_to_order.product_id')
            ->leftJoin('category', 'category.id', '=', 'product.category_id')
            ->where('product_to_order.order_id', $order_id)
            ->get();

        foreach ($products as $i => $item) {
            if (is_file(ROOT . $item->photo_min))
                $products[$i]->photo = $item->photo_min;
            elseif (!is_file(ROOT . $item->photo))
                $products[$i]->photo = '/public/images/no_photo.png';
        }

        return $products;
    }*/

    public static function create($post)
    {
        unset($post->_token);

        $id = DB::table('order')
            ->insertGetId([
                'name' => $post->name,
                'phone' => $post->phone,
                'comment' => $post->comment,
                'created_at' => date('Y-m-d H:i:s'),
                'date_delivery' => date('Y-m-d'),
                'sum' => 0,
                'discount' => 0,
                'delivery_cost' => 0
            ]);

        $sum = 0;
        foreach ($post->products as $product_id => $amount) {
            $product = DB::table('product')->where('id', '=', $product_id)->first();

            $sum += $product->price * $amount;

            DB::table('product_to_order')->insert([
                'order_id' => $id,
                'product_id' => $product_id,
                'amount' => $amount,
                'price' => $product->price
            ]);
        }

        DB::table('order')
            ->where('id', '=', $id)
            ->update(['sum' => $sum]);

        return $id;
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

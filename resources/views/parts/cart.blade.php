<?php function count_products($arr)
{
    $temp = 0;
    if (my_count($arr) > 0) {
        foreach ($arr as $k => $v) {
            $temp += $v;
        }
    }

    return $temp;
} ?>
<div data-toggle="modal" data-target="#cart"
     class="cart-open @if (my_count($_SESSION['cart_products']) == 0) none @endif">
    <i class="fa fa-shopping-cart"></i>
    <span class="cart-count">{{ count_products($_SESSION['cart_products']) }}</span>
</div>


<!-- Modal -->
<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartTitle">Корзина</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cart_form">
                <div class="modal-body">
                    <table class="table @if (my_count($_SESSION['cart_products']) == 0) {{ 'none' }} @endif products">
                        <tbody>
                        @if (my_count($_SESSION['cart_products']) != 0)
                            <?php $count = 0; ?>
                            @foreach(\App\Models\Product::get_cart_products() as $product)
                                <tr class="product" data-id="{{ $product->id }}">
                                    <td class="product_photo">
                                        <img width="70px" height="70px" src="{{ $product->photo }}" alt="image">
                                    </td>
                                    <td class="product_name">
                                        {{ $product->name }}
                                    </td>
                                    <td style="border-top: none;vertical-align: middle;text-align: right;">
                                        <span class="minus_cart action_cart">-</span>
                                        <span class="product_amount">{{ $_COOKIE['cart_products']->{$product->id} }}</span>
                                        <span class="plus_cart action_cart">+</span>
                                    </td>
                                    <td style="border-top: none;vertical-align: middle;text-align: right;">
                                    <span class="product_price">
                                        {{ number_format($product->price * $_COOKIE['cart_products']->{$product->id}, 2) }}
                                    </span> грн
                                        <span class="un_cart">x</span>
                                    </td>
                                </tr>
                                <?php $count += $product->price * $_COOKIE['cart_products']->{$product->id}; ?>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <hr>

                    <div style="text-align: right">
                        Сума заказа: <span style="font-weight: bolder" class="order_sum">{{ isset($count) ? number_format($count, 2) : '' }}
                            грн</span>
                    </div>

                    <hr>

                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input id="name" name="name" class="form-control form-control-sm" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" required id="phone" name="phone" class="form-control form-control-sm">
                    </div>

                    <div class="form-group">
                        <label for="comment">Комментарий</label>
                        <textarea class="form-control form-control-sm" name="comment" id="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button class="btn btn-primary send">Оформить заказ</button>
                </div>
            </form>
        </div>
    </div>
</div>
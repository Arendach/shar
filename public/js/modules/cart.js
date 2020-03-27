$(document).ready(function () {

    var $body = $('body');

    $("#phone").inputmask({"mask": "999-999-99-99"});

    // закрити корзину якщо там пусто
    function is_close_cart() {
        if ($('.products tbody').height() === 0) {
            $('#cart').modal('hide');
            $('.cart-open').fadeOut();
        }
    }

    // підрахунок суми, оновлення куків
    function reset_cookie() {
        var ids = {};
        var count = 0;
        var order_sum = 0;

        $('.products .product').each(function () {
            ids[$(this).data('id')] = $(this).find('.product_amount').text();
            count += +$(this).find('.product_amount').text();
            order_sum += +filterFloat($(this).find('.product_price').text());
        });

        $('.order_sum').text(number_format(order_sum, 2, '.', ',') + ' грн')
        $('.cart-count').text(count);
        $.cookie('cart_products', JSON.stringify(ids));
    }

    // відкрити корзину по кліку
    $body.on('click', '.cart-open', function () {
        $('.cart-open').fadeOut();
    });

    // якщо корзина порожня то сховати значок
    $('#cart').on('hidden.bs.modal', function (e) {
        if (+$('.cart-count').text() != 0)
            $('.cart-open').fadeIn();
    });

    // додати товар до корзини
    $body.on('click', '.to_cart', function () {
        var data = $(this).data('data');

        function create_row(name, id, photo, price) {
            $('#cart .products').append('<tr class="product" data-id="' + id + '">' +
                '<td style="border-top: none" class="product_photo"><img width="70px" height="70px" src="' + photo + '" alt="image"></td>' +
                '<td style="border-top: none; vertical-align: middle; font-weight: bolder" class="product_name">' + name + '</td>' +
                '<td style="border-top: none;vertical-align: middle;text-align: right;">' +
                '<span class="minus_cart action_cart">-</span>' +
                '<span class="product_amount">1</span>' +
                '<span class="plus_cart action_cart">+</span>' +
                '</td>' +
                '<td style="border-top: none;vertical-align: middle;text-align: right;">' +
                '<span class="product_price">' +
                '' + price + '' +
                '</span> грн' +
                '<span class="un_cart">x</span>' +
                '</td>' +
                '</tr>');

            $('.products').removeClass('none');
        }

        function add_amount(id, price) {
            var $row = $('.product[data-id=' + id + ']');
            var now = $row.find('.product_amount').text();
            $row.find('.product_amount').text(+now + 1);
            var $product_price = $row.find('.product_price');
            var now_price = $product_price.text();
            $product_price.text(number_format((+filterFloat(now_price) + +price), 2, '.', ','));
        }

        if ($('.product[data-id=' + data.id + ']').length === 0)
            create_row(data.name, data.id, data.photo, data.price);
        else
            add_amount(data.id, data.price);


        $('.cart-open').fadeIn();

        reset_cookie();

    });

    // видалити товар з корзини
    $body.on('click', '.un_cart', function () {
        var $row = $(this).parents('.product');
        var $cart_count = $('.cart-count');
        var now = $cart_count.text();

        // обновлення кількості товарів у корзині(в червоному кружечку)
        $cart_count.text(+now - +$row.find('.product_amount').text());

        // видалення товару з списку
        $row.remove();

        is_close_cart();

        reset_cookie();
    });

    // додати або відняти н-кількість товару
    $body.on('click', '.action_cart', function () {
        var $row = $(this).parents('.product');
        var $amount = $row.find('.product_amount');
        var $price = $row.find('.product_price');
        var original_price = filterFloat($price.text()) / +$amount.text();

        if ($(this).hasClass('plus_cart')) {
            $amount.text(+$amount.text() + 1);
        } else {
            $amount.text(+$amount.text() - 1);
            if (+$amount.text() == 0) {
                $row.remove();
            }
        }

        $price.text(number_format(original_price * +$amount.text(), 2, '.', ','));

        is_close_cart();

        reset_cookie();
    });

    $body.on('submit', 'form#cart_form', function (event) {
        event.preventDefault();

        if (document.getElementById("cart_form").checkValidity()) {
            var data = $(this).serializeJSON();
            data.action = 'create';
            data.products = {};

            $('.product').each(function () {
                var $row = $(this);
                data.products[$row.data('id')] = $row.find('.product_amount').text();
            });

            $.ajax({
                type: 'post',
                url: '/order',
                data: data,
                success: function (answer) {
                    successHandler(answer);
                },
                error: function (answer) {
                    errorHandler(answer);
                }
            });
        }
    });

});

@extends('layouts.admin')

@section('content')

    <nav class="nav nav-pills nav-justified" role="tablist">
        <a data-toggle="tab" role="tab" href="#main" class="nav-item nav-link active">Главная информация</a>
        <a data-toggle="tab" role="tab" href="#products" class="nav-item nav-link">Товары</a>
    </nav>

    <hr>

    <div class="tab-content">
        <div class="tab-pane active" id="main">
            <form id="update_main">
                <div class="form-group">
                    <label for="name">Имя и фамилия</label>
                    <input id="name" class="form-control form-control-sm" name="name" value="{{ $order->name }}">
                </div>

                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input id="phone" class="form-control form-control-sm" name="phone" value="{{ $order->phone }}">
                </div>

                <div class="form-group">
                    <label for="comment">Комментарий</label>
                    <textarea class="form-control form-control-sm" id="comment"
                              name="comment">{{ $order->comment }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 0">
                    <button class="btn btn-primary btn-sm">Сохранить</button>
                </div>

            </form>
        </div>
        <div class="tab-pane" id="products">
            <table class="table table-bordered">
                <tr>
                    <td>Фото</td>
                    <td>Товар</td>
                    <td>Категория</td>
                    <td>Цена</td>
                    <td>Количество</td>
                    <td>Сума</td>
                    <td>Действия</td>
                </tr>
                @foreach($order->products as $item)
                    <tr>
                        <td width="120px">
                            <a href="{{ $item->product->photo }}">
                                <img src="{{ $item->product->photo }}" width="100px">
                            </a>
                        </td>

                        <td>
                            <a href="{{ url('product?id=' . $item->product_id) }}">{{ $item->product->name }}</a>
                        </td>

                        <td>
                            <a href="{{ url('category?id=' . $item->id) }}">{{ $item->product->category->name }}</a>
                        </td>

                        <td>
                            <input class="form-control form-control-sm" value="{{ $item->price }}">
                        </td>

                        <td>
                            <input class="form-control form-control-sm" value="{{ $item->amount }}">

                        </td>

                        <td>
                            {{ number_format($item->price * $item->amount, 2) }}
                        </td>

                        <td>
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection

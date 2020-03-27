@extends('layouts.admin')

@section('content')

    <div class="right form-group">
        <a href="{{ url('admin/product?section=create') }}" class="btn btn-primary">Новый товар</a>
    </div>

    <table class="table table-bordered">
        <tr>
            <td style="font-weight: bolder">Название</td>
            <td style="font-weight: bolder">Категория</td>
            <td style="font-weight: bolder">Артикул</td>
            <td style="font-weight: bolder">Цена</td>
            <td style="font-weight: bolder">Наличие</td>
            <td style="font-weight: bolder" class="action-2 centered">Действия</td>
        </tr>
        <tr>
            <td>
                <input name="name" class="filter" value="{{ $_GET['name'] ?? '' }}">
            </td>

            <td>
                <select name="category" class="filter">
                    <option value=""></option>
                    @foreach($categories as $category)
                        <option {{ get('category') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <input name="articul" class="filter" value="{{ $_GET['articul'] ?? '' }}">
            </td>

            <td>
                <input name="price" class="filter" value="{{ $_GET['price'] ?? '' }}">
            </td>

            <td>
                <select name="on_storage" class="filter">
                    <option value=""></option>
                    <option {{ isset($_GET['on_storage']) && $_GET['on_storage'] == 0 ? 'selected' : ''  }} value="0">
                        Нет
                    </option>
                    <option {{ get('on_storage') == 1 ? 'selected' : ''  }} value="1">
                        Да
                    </option>
                </select>
            </td>

            <td class="action-2 centered">
                <button class="btn btn-outline-primary" id="filter">
                    <i class="fa fa-search"></i>
                </button>
            </td>
        </tr>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->articul }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ $item->on_storage ? 'Есть' : 'Нет' }}</td>
                <td class="action-2 centered">
                    <a href="{{ url('admin/product?section=update&id=' . $item->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $items->links() }}

    <script>
        $(document).ready(function () {
            let serialize = function(obj) {
                let str = [];
                for (let p in obj)
                    if (obj.hasOwnProperty(p)) {
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    }
                return str.join("&");
            };

            let filter = function (){
                let data = {};

                $('.filter').each(function () {
                    if ($(this).val() != '') data[$(this).attr('name')] = $(this).val();
                });

                window.location.href = '/admin/product?' + serialize(data);
            };

           $(document).on('click', '#filter', filter);

           $(document).on('change', '[name="on_storage"],[name="category"]', filter);

           $(document).on('change', '[name="on_storage"],[name="category"]', filter);

           $(document).on('keyup', '.filter', function (e) {
                if (e.which == 13) filter();
            });
        });
    </script>


@endsection('content')

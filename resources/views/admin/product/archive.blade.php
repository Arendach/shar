@extends('layouts.admin')

@section('content')

    <table class="table table-bordered">
        <tr>
            <td>Название</td>
            <td>Категория</td>
            <td>Закупочная цена</td>
            <td>Цена</td>
            <td>На складе</td>
            <td class="action-2">Действия</td>
        </tr>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category_name }}</td>
                <td>{{ $item->purchase_price }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->count_on_storage }}</td>
                <td class="action-2">
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


@endsection('content')
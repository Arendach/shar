@extends('layouts.admin')

@section('content')

    <table class="table table-bordered">
        <tr>
            <td>Имя</td>
            <td>Телефон</td>
            <td>Дата</td>
            <td>Сума заказа</td>
            <td style="width: 100px; text-align: center">Действия</td>
        </tr>
        @foreach($orders as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->sum }}</td>
                <td style="width: 100px; text-align: center">
                    @if($item->accepted == 0)
                        <button data-type="ajax_request"
                                data-post="{{ params(['id' => $item->id]) }}"
                                data-uri="{{ uri('admin/order') }}"
                                data-action="accepted"
                                class="btn btn-sm btn-outline-info">
                            <i class="fa fa-check"></i>
                        </button>
                    @else
                        <button data-toggle="tooltip" title="{{ $item->user->login }}" class="btn btn-sm btn-info">
                            <i class="fa fa-check"></i>
                        </button>
                    @endif
                    <a href="{{ url("admin/order?section=update&id={$item->id}") }}" title="Редактировать"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $orders->links() }}

@endsection('content')

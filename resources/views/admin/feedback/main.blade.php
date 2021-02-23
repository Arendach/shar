@extends('layouts.admin')

@section('content')

    @if(count($feedback) > 0)
        <table class="table-bordered table">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Дата</th>
                <th style="width: 127px">Действия</th>
            </tr>
            @foreach($feedback as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                    <td style="width: 127px">
                        @if($item->accepted == 0)
                            <button data-type="ajax_request"
                                    data-uri="{{ uri('admin/feedback') }}"
                                    data-action="accepted"
                                    data-post="{{ params(['id' => $item->id]) }}"
                                    class="btn btn-sm btn-outline-info">
                                <i class="fa fa-check"></i>
                            </button>
                        @else
                            <button class="btn btn-sm btn-info">
                                <i class="fa fa-check"></i>
                            </button>
                        @endif{{----}}
                        <a href="{{ uri('admin/feedback/' . $item->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button data-type="delete"
                                data-uri="{{ uri('admin/feedback') }}"
                                data-action="delete"
                                data-id="{{ $item->id }}"
                                class="btn btn-sm btn-outline-danger">
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="centered">
            {{ $feedback->links() }}
        </div>
    @else
        <h4 class="centered">Тут пусто!</h4>
    @endif

@endsection('content')
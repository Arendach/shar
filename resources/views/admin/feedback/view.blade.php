@extends('layouts.admin')

@section('content')

    <table class="table table-bordered">
        <tr>
            <td>Имя</td>
            <td>{{ $feedback->name }}</td>
        </tr>

        <tr>
            <td>Телефон</td>
            <td>{{ $feedback->phone }}</td>
        </tr>
        <tr>
            <td>Сообщение</td>
            <td>{{ $feedback->message == '' ? 'Не заполнено' : $feedback->message }}</td>
        </tr>
        <tr>
            <td>Создано</td>
            <td>{{ date('Y.m.d H:i', strtotime($feedback->created_at)) }}</td>
        </tr>
        <tr>
            <td>Принято</td>
            <td>{{ $feedback->accepted != 0 ? user($feedback->accepted)->login : 'Не принято' }}</td>
        </tr>
    </table>

@endsection('content')
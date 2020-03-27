@extends('layouts.admin')

@section('content')

    <div class="right" style="margin-bottom: 15px;">
        <button data-type="get_form"
                data-uri="{{ uri('admin/user') }}"
                data-action="register_form"
                class="btn btn-primary">Регистрировать
        </button>
    </div>

    <table class="table-bordered table">
        <tr>
            <th>Логин</th>
            <th>Группа доступа</th>
            <th>Имя</th>
            <th class="action-2 centered">
                Действия
            </th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->login }}</td>
                <td>
                    @if($user->access == -1)
                        root
                    @elseif(isset($access[$user->access]))
                        {{ $access[$user->access]->name }}
                    @else
                        Группа не найдена
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td class="action-2 centered">
                    <button data-type="get_form"
                            data-uri="{{ uri('admin/user') }}"
                            data-action="update_form"
                            data-post="{{ params(['id' => $user->id]) }}"
                            class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil"></i>
                    </button>

                    <button data-type="delete"
                            data-uri="{{ uri('admin/user') }}"
                            data-action="delete"
                            data-id="{{ $user->id }}"
                            class="btn btn-danger btn-sm">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </table>

@endsection('content')
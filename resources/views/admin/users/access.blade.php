@extends('layouts.admin')

@section('content')

    <div class="right" style="margin-bottom: 15px;">
        <button data-type="get_form"
                data-uri="{{ uri('admin/user') }}"
                data-action="create_access_group_form"
                class="btn btn-primary">
            Новая группа
        </button>
    </div>

    @if(my_count($access_groups) > 0)
        <table class="table-bordered table">
            <tr>
                <th>Название</th>
                <th>Ключи</th>
                <th class="action-2 centered">Действия</th>
            </tr>
            @foreach($access_groups as $item)
                <tr>
                    <td>
                        {{ $item->name }}
                    </td>

                    <td>
                        <?php
                        $keys = json_decode($item->array);
                        $access = config('access_keys')
                        ?>
                        @if(my_count($keys) > 0)
                            @foreach($keys as $key)
                                <div>{{ $access[$key]['name'] }}</div>
                            @endforeach
                        @else
                            Ключей нет
                        @endif
                    </td>

                    <td class="action-2 centered">
                        <button data-type="get_form"
                                data-uri="{{ uri('admin/user') }}"
                                data-action="update_access_group_form"
                                data-post="{{ params(['id' => $item->id]) }}"
                                class="btn btn-sm btn-primary">
                            <i class="fa fa-pencil"></i>
                        </button>

                        <button data-type="delete"
                                data-uri="{{ uri('admin/user') }}"
                                data-action="delete_access_group"
                                data-id="{{ $item->id }}"
                                class="btn btn-sm btn-danger">
                            <i class="fa fa-remove"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <h4 class="centered">Здесь пусто :(</h4>
    @endif

@endsection('content')
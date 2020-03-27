@extends('layouts.modal')

@section('content')

    <form action="{{ uri('admin/user') }}" data-type="ajax">

        <input type="hidden" name="action" value="create_access_group">

        <div class="form-group">
            <label for="name">Название группы</label>
            <input class="form-control form-control-sm" required id="name" name="name">
        </div>

        <div class="form-group">
            <label for="">Ключи</label> <br>
            @foreach(config('access_keys') as $key => $item)
                <label for="{{ $key }}" style="margin-left: 15px;">
                    <input type="checkbox" name="{{ $key }}"> {{ $item['name'] }}
                </label>
                <br>
            @endforeach
        </div>

        <div class="form-group" style="margin-bottom: 0">
            <button class="btn btn-primary btn-sm">Сохранить</button>
        </div>
    </form>

@endsection('content')
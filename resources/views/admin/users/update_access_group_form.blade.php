@extends('layouts.modal')

@section('content')

    <form action="{{ uri('admin/user') }}" data-type="ajax">

        <input type="hidden" name="action" value="update_access_group">
        <input type="hidden" name="id" value="{{ $access->id }}">

        <div class="form-group">
            <label for="name">Название группы</label>
            <input value="{{ $access->name }}" class="form-control form-control-sm" required id="name" name="name">
        </div>

        <div class="form-group">
            <label for="">Ключи</label> <br>
            @foreach(config('access_keys') as $key => $item)
                <label for="{{ $key }}" style="margin-left: 15px;">
                    <input {{ in_array($key, get_array(json_decode($access->array))) ? 'checked' : '' }} type="checkbox" name="{{ $key }}"> {{ $item['name'] }}
                </label>
                <br>
            @endforeach
        </div>

        <div class="form-group" style="margin-bottom: 0">
            <button class="btn btn-primary btn-sm">Сохранить</button>
        </div>
    </form>

@endsection('content')
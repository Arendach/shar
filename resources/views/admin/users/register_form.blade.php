@extends('layouts.modal')

@section('content')

    <form action="{{ uri('admin/user') }}" data-type="ajax">
        <input type="hidden" name="action" value="register">

        <div class="form-group">
            <label for="login"> <i class="text-danger">*</i> Логин</label>
            <input required pattern="[a-zA-Z0-9]{3-16}" autocomplete="off" id="login" name="login" class="form-control form-control-sm">
        </div>

        <div class="form-group">
            <label for="password"> <i class="text-danger">*</i> Пароль</label>
            <input required pattern=".*{6-16}" autocomplete="off" id="password" name="password" type="password"
                   class="form-control form-control-sm">
        </div>

        <div class="form-group">
            <label for="password_conf"> <i class="text-danger">*</i> Повторите пароль</label>
            <input required pattern=".*{6-16}" autocomplete="off" id="password_conf" name="password_conf" type="password"
                   class="form-control form-control-sm">
        </div>

        <div class="form-group">
            <label for="name"> <i class="text-danger">*</i> Имя</label>
            <input required id="name" name="name" class="form-control form-control-sm">
        </div>

        <div class="form-group">
            <label for="access"> <i class="text-danger">*</i> Группа доступа</label>
            <select required name="access" id="access" class="form-control form-control-sm">
                <option value="-1">root</option>
                @foreach($access as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <button class="btn btn-primary btn-sm">Сохранить</button>
        </div>
    </form>

@endsection('content')
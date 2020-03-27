@extends('layouts.modal')

@section('content')

    <ul class="nav nav-pills nav-justified" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Общиие данные</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Пароль</a>
        </li>
    </ul>

    <div class="tab-content" style="margin-top: 15px;">
        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <form action="{{ uri('admin/user') }}" data-type="ajax">
                <input type="hidden" name="action" value="update_info">
                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="form-group">
                    <label for="login"> <i class="text-danger">*</i> Логин</label>
                    <input value="{{ $user->login }}" required pattern="[a-zA-Z0-9]{3-16}" autocomplete="off" id="login" name="login" class="form-control form-control-sm">
                </div>

                <div class="form-group">
                    <label for="name"> <i class="text-danger">*</i> Имя</label>
                    <input value="{{ $user->name }}" required id="name" name="name" class="form-control form-control-sm">
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
        </div>

        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <form action="{{ uri('admin/user') }}" data-type="ajax">
                <input type="hidden" name="action" value="update_password">
                <input type="hidden" name="id" value="{{ $user->id }}">

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

                <div class="form-group" style="margin-bottom: 0;">
                    <button class="btn btn-primary btn-sm">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

@endsection('content')
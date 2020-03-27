@extends('layouts.modal')

@section('content')

    <form data-type="ajax" action="{{ uri('admin/product') }}">
        <input type="hidden" name="id" value="{{ $photo->id }}">
        <input type="hidden" name="action" value="update_photo_description">

        <div class="form-group">
            <label for="description">Описание</label>
            <input id="description" name="description" class="form-control form-control-sm" value="{{ $photo->description }}">
        </div>

        <div class="form-group" style="margin-bottom: 0;">
            <button class="btn btn-sm btn-primary">Сохранить</button>
        </div>

    </form>

@endsection('content')
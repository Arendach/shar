@extends('layouts.admin')

@section('content')

    <form id="create">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="name"><i class="text-danger">*</i> Название</label>
            <input class="form-control form-control-sm" id="name" name="name">
        </div>

        <div class="form-group">
            <label for="price"><i class="text-danger">*</i> Цена</label>
            <input class="form-control form-control-sm" id="price" name="price">
        </div>

        <div class="form-group">
            <label for="articul"><i class="text-danger">*</i> Артикул</label>
            <input class="form-control form-control-sm" id="articul" name="articul">
        </div>

        <div class="form-group">
            <label for="category_id"><i class="text-danger">*</i> Категория</label>
            <select class="form-control form-control-sm" id="category_id" name="category_id">
                @foreach($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="short">Краткое описание</label>
            <textarea class="form-control form-control-sm" id="short" name="short"></textarea>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control form-control-sm" id="description" name="description"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 0">
            <button class="btn btn-primary">Сохранить</button>
        </div>

    </form>

    <script>
        CKEDITOR.replace( 'short' );
        CKEDITOR.replace( 'description' );
    </script>

@endsection('content')
@extends('layouts.admin')

@section('content')

    <form id="update">

        {{ csrf_field() }}

        <input type="hidden" name="id" value="{{ $category->id }}">

        <div class="form-group">
            <label for="name"><i class="text-danger">*</i> Имя</label>
            <input id="name" name="name" class="form-control form-control-sm" value="{{ $category->name }}">
        </div>

        <div class="form-group">
            <label for="meta_title"><i class="text-danger">*</i> Заголовок (тег title)</label>
            <input class="form-control form-control-sm" name="meta_title" id="meta_title" value="{{ $category->meta_title }}">
        </div>

        <div class="form-group">
            <label for="description"><i class="text-danger">*</i> Описание</label>
            <textarea class="form-control form-control-sm" name="description" id="description">{{ $category->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="meta_keywords">Ключевые слова</label>
            <input id="meta_keywords" name="meta_keywords" class="form-control form-control-sm" value="{{ $category->meta_keywords }}">
        </div>

        <div class="form-group">
            <label for="meta_description">Мета описание</label>
            <input id="meta_description" name="meta_description" class="form-control form-control-sm" value="{{ $category->meta_description }}">
        </div>

        <div class="form-group">
            <label>Приоритет сортировки(чем больше цифра тем выше категория)</label>
            <input type="number" name="sort" class="form-control form-control-sm" value="{{ $category->sort }}">
        </div>


        <div class="form-group" style="margin-bottom: 0">
            <button class="btn btn-sm btn-primary">Сохранить</button>
        </div>

    </form>

@endsection('content')

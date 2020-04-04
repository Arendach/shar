<?php

/**
 * @var \App\Models\Product $product
 * @var Illuminate\Support\Collection $categories
 */

?>

@extends('layouts.admin')

@section('content')

    <style>
        .file {
            position: relative;
            display: block;
            border: 1px dashed #ccc;
            padding: 10px;
            margin-bottom: 15px;
        }

        .description_photo {
            margin-left: 15px;
            display: inline-block;
            vertical-align: middle;
            width: calc(100% - 15px - 150px - 30px);
        }

        .delete_photo {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .update_photo {
            position: absolute;
            top: 10px;
            right: calc(5px + 10px + 30px);
        }

        span.file_select {
            display: block;
            border: 1px dashed #ccc;
            padding: 30px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            color: #aaa;
        }

        label.file_select {
            display: block;
        }

        #file_names, #file_name {
            font-size: 12px;
            color: #aaa;
        }
    </style>

    <nav class="nav nav-pills nav-justified" role="tablist">
        <a data-toggle="tab" role="tab" href="#main" class="nav-item nav-link active">Главная информация</a>
        <a data-toggle="tab" role="tab" href="#photo" class="nav-item nav-link">Главное фото</a>
        <a data-toggle="tab" role="tab" href="#photo_gallery" class="nav-item nav-link">Фотогалерея</a>
        <a data-toggle="tab" role="tab" href="#other" class="nav-item nav-link">Остальное</a>
    </nav>

    <hr>

    <div class="tab-content">
        <div class="tab-pane active" id="main">
            <form id="update_main">

                {{ csrf_field() }}

                <input type="hidden" name="id" value="{{ $product->id }}">

                <div class="form-group">
                    <label for="name"><i class="text-danger">*</i> Название</label>
                    <input class="form-control form-control-sm" id="name" name="name" value="{{ $product->name }}">
                </div>

                <div class="form-group">
                    <label for="price"><i class="text-danger">*</i> Цена</label>
                    <input class="form-control form-control-sm" id="price" name="price" value="{{ $product->price }}">
                </div>

                <div class="form-group">
                    <label for="priority">Приоритет</label>
                    <input class="form-control form-control-sm" id="priority" name="priority" value="{{ $product->priority }}">
                </div>

                <div class="form-group">
                    <label for="articul"><i class="text-danger">*</i> Артикул</label>
                    <input class="form-control form-control-sm" id="articul" name="articul"
                           value="{{ $product->articul }}">
                </div>

                <div class="form-group">
                    <label for="category_id"><i class="text-danger">*</i> Категория</label>
                    <select class="form-control form-control-sm" id="category_id" name="category_id">
                        @foreach($categories as $category)
                            <option
                                {{ $product->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="short">Краткое описание</label>
                    <textarea class="form-control form-control-sm" id="short"
                              name="short">{{ $product->short }}</textarea>
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control form-control-sm" id="description"
                              name="description">{{ trim($product->description) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 0">
                    <button class="btn btn-primary btn-sm">Сохранить</button>
                </div>

            </form>
        </div>

        <div class="tab-pane" id="photo">

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <form id="update_photo" enctype="multipart/form-data" method="POST">

                        {{csrf_field()}}

                        <input type="hidden" name="id" value="{{ $product->id }}">

                        <input type="hidden" name="action" value="update_photo">

                        <div class="form-group">
                            <label class="file_select">
                                <input style="display: none" type="file" name="file" accept="image/*">
                                <span class="file_select">Выбрать файл</span>
                            </label>
                        </div>

                        <div id="file_name"></div>

                        <div class="form-group">
                            <input placeholder="Описание" class="form-control" name="description">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-sm btn-block">Сохранить</button>
                        </div>

                    </form>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                    <div class="centered">
                        <img id="photo" src="{{ $product->photo_min }}" width="500px">
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane" id="photo_gallery">

            <div class="row">

                <div class="col-3">
                    <form id="add_photo" enctype="multipart/form-data" method="POST">

                        {{csrf_field()}}

                        <input type="hidden" name="id" value="{{ $product->id }}">

                        <input type="hidden" name="action" value="add_photo">

                        <div class="form-group">
                            <label class="file_select">
                                <input style="display: none" multiple="multiple" type="file" name="files[]"
                                       accept="image/*">
                                <span class="file_select">Выбрать файлы</span>
                            </label>
                        </div>


                        <div id="file_names"></div>

                        <div class="form-group">
                            <input placeholder="Описание" class="form-control" name="description">
                        </div>

                        <div id="place_for_load"></div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-sm btn-block">Сохранить</button>
                        </div>

                    </form>

                </div>

                <div class="col-9 photo_container">
                @foreach($product->images as $item)

                    @continue(!is_file($item->getOriginal('path_large')))

                    <?php list($width_large, $height_large, $type_large, $attr_large) = getimagesize(public_path($item->getOriginal('path_large'))) ?>
                        <?php list($width_min, $height_min, $type_min, $attr_min) = getimagesize(public_path($item->getOriginal('path_min'))) ?>

                        <a target="_blank" class="file" href="{{ asset($item->path_large) }}">
                            <img width="150px" src="{{ asset($item->path_min) }}">

                            <div class="description_photo">
                                Файл: {{ pathinfo($item->path_large)['basename'] }}<br>
                                Дата: <?= date("Y.m.d H:i", filemtime(public_path($item->getOriginal('path_large')))); ?><br>
                                Размер миниатюры: {{ $width_min . 'x' . $height_min }}px
                                ({{ my_file_size(filesize(public_path($item->getOriginal('path_min')))) }})<br>
                                Размер исходного: {{ $width_large . 'x' . $height_large }}px
                                ({{ my_file_size(filesize(public_path($item->getOriginal('path_large')))) }})
                                @if($item->description != '')
                                    <br> Описание: {{ $item->description }}
                                @endif
                            </div>

                            <button data-type="get_form"
                                    data-uri="{{ uri('admin/product') }}"
                                    data-action="update_photo_description_form"
                                    data-post="{{ params(['id' => $item->id]) }}"
                                    class="update_photo btn btn-outline-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                            </button>

                            <button class="delete_photo btn btn-outline-danger btn-sm" title="Удалить"
                                    data-id="{{ $item->id }}" data-toggle="tooltip">
                                <i class="fa fa-remove"></i>
                            </button>
                        </a>

                    @endforeach
                </div>

            </div>

        </div>

        <div class="tab-pane" id="other">
            <form id="update_other">

                {{ csrf_field() }}

                <input type="hidden" name="id" value="{{ $product->id }}">

                <div class="form-group">
                    <label for="on_storage"><i class="text-danger">*</i> Наличие на складе</label>
                    <select class="form-control form-control-sm" name="on_storage" id="on_storage">
                        <option {{ !$product->on_storage ? 'selected' : '' }} value="0">Нет в наличии</option>
                        <option {{ $product->on_storage ? 'selected' : '' }} value="1">Есть в наличии</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="public"><i class="text-danger">*</i> Публикация</label>
                    <select type="text" class="form-control form-control-sm" name="public" id="public">
                        <option {{ $product->public == '0' ? 'selected' : '' }} value="0">Не публикован</option>
                        <option {{ $product->public == '1' ? 'selected' : '' }} value="1">Публикован</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="meta_title"><i class="text-danger">*</i> Заголовок (тег title)</label>
                    <input type="text" class="form-control form-control-sm" name="meta_title" id="meta_title"
                           value="{{ $product->meta_title }}">
                </div>

                <div class="form-group">
                    <label for="meta_keywords">Ключевие слова (meta keywords)</label>
                    <input type="text" class="form-control form-control-sm" name="meta_keywords" id="meta_keywords"
                           value="{{ $product->meta_keywords }}">
                </div>

                <div class="form-group">
                    <label for="meta_description">Мета описание (meta description)</label>
                    <input type="text" class="form-control form-control-sm" name="meta_description"
                           id="meta_description" value="{{ $product->meta_description }}">
                </div>

                <div class="form-group" style="margin-bottom: 0">
                    <button class="btn btn-primary btn-sm">Сохранить</button>
                </div>


            </form>
        </div>

    </div>

    <script>
        CKEDITOR.replace('short');
        CKEDITOR.replace('description');

        $(document).ready(function () {
            var $body = $('body');

            $body.on('click', '.delete_photo', function (event) {
                event.preventDefault();

                var $this = $(this);

                var data = {
                    id: $this.data('id'),
                    action: 'delete_photo'
                };

                delete_on_click(function () {
                    $.ajax({
                        url: url('admin/product'),
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function (answer) {
                            swal({
                                title: 'Выполнено',
                                type: 'success',
                                text: answer.message
                            });

                            $this.parents('a').remove();
                        },
                        error: function (answer) {
                            errorHandler(answer);
                        }
                    });
                });
            });
        });
    </script>

@endsection('content')

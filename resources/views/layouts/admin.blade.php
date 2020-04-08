<?php include resource_path('/views/parts/components.blade.php') ?>
        <!doctype html>
<html lang="ru">
<head>
    <script>
        function url(p) {
            return '{{ env('APP_URL') }}/' + p;
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/jquery.input_mask.js') }}"></script>
    <script src="{{ asset('js/jquery.serialize_json.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>
    {!!  $js_components !!}
    @yield('js')

    <script defer src="{{ asset('admin_files/js/custom.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_files/css/custom.css') }}">

    {!! $css_components !!}
    <title>
        @isset($title)
            {{ 'Админка :: ' . $title }}
        @else
            Введите заголовок
        @endif
    </title>

    @isset($css)
        @foreach($css as $item)
            <link rel="stylesheet" href="{{ $item }}">
        @endforeach
    @endisset

    @isset($js)
        @foreach($js as $item)
            <script src="{{ $item }}"></script>
        @endforeach
    @endisset
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">AdminPanel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <?php if (can('orders')) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/order') }}">Заказы</a>
                </li>
                <?php } ?>

                <li class="nav-item">
                    <a class="nav-link {{ \App\Models\Feedback::where('accepted', 0)->count() ? 'text-danger' : '' }}" href="{{ url('/admin/feedback') }}">
                        Перезвонить срочно
                    </a>
                </li>

                <?php if (can('settings')) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="{{ uri('/admin/settings') }}">Настройки</a>
                </li>
                <?php } ?>

                <?php if (can('categories') || can('products')){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Каталог
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if (can('categories')){ ?>
                        <a class="dropdown-item" href="{{ uri('/admin/category') }}">
                            Категории
                        </a>
                        <?php } ?>
                        <?php if (can('products')){ ?>
                        <a class="dropdown-item" href="{{ uri('/admin/product') }}">
                            Товары
                        </a>
                        <?php } ?>
                    </div>
                </li>
                <?php } ?>

                <?php if (can('users')) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Пользователи
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ uri('/admin/user') }}">
                            Список пользователей
                        </a>
                        <a class="dropdown-item" href="{{ uri('/admin/user', ['section' => 'access']) }}">
                            Настройки доступа
                        </a>
                    </div>
                </li>
                <?php } ?>

                <?php if (can('categories') || can('products')){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Архив
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if (can('products')){ ?>
                        <a class="dropdown-item" href="{{ uri('admin/product?section=archive') }}">Товары</a>
                        <?php } ?>

                        <?php if (can('categories')){ ?>
                        <a class="dropdown-item" href="{{ uri('admin/category?section=archive') }}">Категории</a>
                        <?php } ?>
                    </div>
                </li>
                <?php } ?>

                @if(can())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Другое
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a style="color: red" class="dropdown-item" href="{{ uri('/phpmyadmin/index.php') }}">PhpMyAdmin</a>
                            <a style="color: red" class="dropdown-item" href="{{ uri('/explorer/index.php') }}">Файловый
                                менеджер</a>
                        </div>
                    </li>
                @endif
            </ul>

            <div class="form-inline my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i> {{ user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a data-token="{{ csrf_token() }}" data-type="exit" class="dropdown-item"
                               href="{{ uri('admin/user', ['section' => 'exit']) }}">Выход</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <hr>

    @include('admin.breadcrumb')

    <hr>

    @if(isset($notifications) || isset($notification))
        @isset($notification)
            @include('parts.notification')
        @endisset

        @isset($notifications)
            @foreach($notifications as $notification)
                @include('parts.notification')
            @endforeach
        @endisset
        <hr id="notification_hr">
    @endisset


    <div class="row content">
        <div class="col-12">
            @yield('content')
        </div>
    </div>

    <hr>

    <div class="row footer">
        <div class="col-12">
            &copy; Arenach Taras 2017 - {{ date('Y') }}
        </div>
    </div>
</div>

</body>
</html>

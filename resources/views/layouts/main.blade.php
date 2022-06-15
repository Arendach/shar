<!doctype html>
<html lang="ru">
<head>
    @include('parts.google-analytics')
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ $meta_description ?? settings('seo.meta_description_default') }}">
    <meta name="keywords" content="{{ $meta_keywords ?? settings('seo.meta_keywords_default')  }}">
    <meta name="robots" content="index,follow">

    <meta property="og:title" content="{{ $title ?? '' }}"/>
    <meta property="og:description" content="{{ $meta_description ?? settings('seo.meta_description_default') }}"/>

    @isset($product->photo)
        <meta property="og:url" content="{{ $product->photo }}"/>
    @endisset
    <meta property="og:site_name" content="shar.kiev.ua"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ $title ?? 'Enter Title' }}</title>
</head>
<body>


<header>
    <div class="container-fluid">
        <div class="row top-head">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center centered">
                {!! settings('main.address') !!}
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center">
                <a target="_blank" href="tel:{!! preg_replace('/\,/', '<br>', settings('main.phone')) !!}">
                    <i class="fa fa-phone"></i> {!! preg_replace('/\,/', '<br>', settings('main.phone')) !!}
                </a><br>
                <a target="_blank" href="tel:+3800994170135">
                    <i class="fa fa-phone"></i> +38 ‎(098) 417-01-35
                </a><br>
                <a target="_blank" href="tel:+3800994170135">
                    <i class="fa fa-phone"></i> +38 ‎(099) 417-01-35
                </a><br>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=380632479135">
                    <i class="fa fa-whatsapp"></i> WhatsApp
                </a>
                <br>
                <a target="_blank" href="viber://chat?number=+380632479135" >
                    <i class="fa fa-whatsapp"></i> Viber
                </a><br>

                <a target="_blank" href="https://t.me/zakaz_sharov_vozdushno">
                    <i class="fa fa-telegram"></i> Telegram
                </a>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center">
                {!! preg_replace('/\,/', '<br>', settings('main.schedule')) !!}
            </div>
        </div>

        <hr>

        <div class="container">
            <form id="search" class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 mb-3 mb-sm-3 mb-md-3 mb-lg-0 mb-xl-0">
                    <input required value="{{ $search_query ?? '' }}" placeholder="Поиск товаров ..." name="query"
                           type="search" class="form-control">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-search"></i> Начать
                    </button>
                </div>
            </form>
        </div>

        <hr>

        <div class="row align-items-center">
            <div class="col-12">
                <ul style="-webkit-padding-start: 0;">
                    @foreach($categories as $categoryItem)
                        @continue(!$categoryItem->products_count)
                        <li>
                            <a href="{{ $categoryItem->url }}">
                                {{ $categoryItem->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</header>

@include('parts.breadcrumbs')

@yield('content')


<footer>
    {!! settings('main.copy') !!}
</footer>

@include('parts.cart')

@include('parts.feedback')

<a href="#" style="z-index: 2" class="scrollup">Наверх</a>

<script src="{{ asset('js/app.js') }}"></script>

@yield('js')

</body>
</html>

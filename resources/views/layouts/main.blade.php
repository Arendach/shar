<?php include resource_path('views/parts/components.blade.php') ?>

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

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery.serialize_json.js') }}"></script>
    <script src="{{ asset('js/jquery.input_mask.js') }}"></script>
    <script src="{{ asset('js/components/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('js/components/sweetalert/sweetalert_functions.js') }}"></script>
    <script src="{{ asset('js/modules/cart.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>

    {!!  $js_components !!}

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/sweetalert/sweetalert.css') }}">

    {!!  $css_components !!}

    @isset($css)
        @foreach($css as $item)
            <link rel="stylesheet" href="{{ asset("css/$item.css") }}">
        @endforeach
    @endisset
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">

    @if(Agent::isDesktop())
        <link rel="stylesheet" href="{{ asset('css/desktop.css') }}">
        <script src="{{ asset('js/desktop.js') }}"></script>
    @else
        <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    @endif

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
                {!! preg_replace('/\,/', '<br>', settings('main.phone')) !!} <br>
                @if(!Agent::isDesktop())
                    <a target="_blank" href="tel:+380687858529">
                        <i class="fa fa-phone"></i> +38 ‎(068) 785-85-29
                    </a><br>
                @else
                    +38 ‎(068) 785-85-29 <br>
                @endif
                <a target="_blank" href="https://api.whatsapp.com/send?phone=380687858529">
                    <i class="fa fa-whatsapp"></i> WhatsApp
                </a>
                <br>
                <a target="_blank" href="viber://chat?number=+380687858529">
                    <i class="fa fa-whatsapp"></i> Viber
                </a>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center">
                {!! preg_replace('/\,/', '<br>', settings('main.schedule')) !!}
            </div>
        </div>

        <hr>

        @if(Agent::isDesktop())
            <div class="container">
                <form id="search" class="row">
                    <div class="col-10">
                        <input required value="{{ $search_query ?? '' }}" placeholder="Начните вводить..." name="query"
                               type="search" class="form-control">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-search"></i> Поиск по сайту
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="container">
                <form id="search" class="row">
                    <div class="col-12" style="margin-bottom: 10px">
                        <input required value="{{ $search_query ?? '' }}" placeholder="Начните вводить..." name="query"
                               type="search" class="form-control form-control-sm">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block btn-sm">
                            <i class="fa fa-search"></i> Поиск по сайту
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <hr>

        <div class="row align-items-center">
            <div class="col-12">
                <ul style="-webkit-padding-start: 0;">
                    @foreach($categories as $item)
                        <li>
                            <a href="{{ uri('category', ['id' => $item->id]) }}">
                                {{ $item->name }}
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
<!--
<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div data-mobile-view="true" data-share-size="30" data-like-text-enable="false" data-background-alpha="0.0" data-pid="1829311" data-mode="share" data-background-color="#ffffff" data-hover-effect="rotate-cw" data-share-shape="round-rectangle" data-share-counter-size="10" data-icon-color="#ffffff" data-mobile-sn-ids="fb.vk.tw.ok.wh.tm.vb." data-text-color="#000000" data-buttons-color="#ffffff" data-counter-background-color="#a4d21f" data-share-counter-type="disable" data-orientation="fixed-left" data-following-enable="false" data-sn-ids="fb.wh.tm.vb.em." data-preview-mobile="false" data-selection-enable="true" data-exclude-show-more="false" data-share-style="9" data-counter-background-alpha="1.0" data-top-button="false" class="uptolike-buttons" ></div>-->

</body>
</html>

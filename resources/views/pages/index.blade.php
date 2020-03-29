@extends('layouts.main')

@section('content')

    <h1 class="none">{{ settings('seo.h1') }}</h1>

    <section>
        <div class="layer"
             style="background-image: url({!! settings('layer.image') !!}); color: {!! settings('layer.color') !!}">
            {!! settings('layer.text') !!}
        </div>

        @forelse($items as $category)
            @continue(!$category->products_count)

            <h2 class="title">
                {{ $category->name }}
                <div class="description">
                    {!! $category->description !!}
                </div>
            </h2>

            <div class="container">
                <div class="products-cat">
                    @foreach($category->products as $item)
                        <div class="product-cat">
                            <a href="{{ $item->url }}">
                                <img class="lazy" src="{{ $item->lazy }}" data-src="{{ $item->photo_min }}"
                                     alt="{{ $item->name }}">
                            </a>
                            <h3 class="product-name">{{ $item->name }}</h3>

                            <div class="product-cat-footer">
                                <div class="product-cat-price">
                                    Цена: <b>{{ number_format($item->price) }} грн</b>
                                </div>
                                <div class="product-cat-buttons">
                                    <a class="btn btn-primary" href="{{ $item->url }}">
                                        Подробнее
                                    </a>
                                    <button data-data="{{ json_encode([
                                                'name' => $item->name,
                                                'price' => $item->price,
                                                'id' => $item->id,
                                                'photo' => $item->photo_min
                                                ]) }}" class="btn btn-primary to_cart">В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($category->products_count > $category->products->count())
                        <div class="product-cat" style="text-align: center; display: flex">
                            <div style="margin: auto">
                                <a href="{{ $category->url }}">
                                    <img src="{{ asset('images/more.svg') }}" alt="Больше товаров данной категории">
                                </a>

                                <br>

                                <a style="font-size: 25px" href="{{ $category->url }}">
                                    Больше товаров данной категории
                                </a>
                            </div>

                        </div>
                    @endif
                </div>
            </div>
        @empty

            <h1 style="text-align: center; margin: 100px 0">Здесь пусто:(</h1>

        @endforelse

    </section>

@endsection

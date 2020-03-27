@extends('layouts.main')

@section('content')

    <h1 class="none">{{ settings('seo.h1') }}</h1>
    <section>
        <div class="layer"
             style="background-image: url({!! settings('layer.image') !!}); color: {!! settings('layer.color') !!}">
            {!! settings('layer.text') !!}
        </div>

        @forelse($items as $category)

            @continue(!$category->products->count())

            <h2 class="title">
                <?= $category->name ?><br>
                <div class="description">
                    <?= $category->description ?>
                </div>
            </h2>
            <div class="container">
                <div class="products-cat">
                    @foreach($category->products as $item)
                        <div class="product-cat">
                            <a href="{{ uri('product', ['id' => $item->id]) }}">
                                <img src="{{ $item->photo_min }}" alt="">
                            </a>
                            <h3 class="product-name">{{ $item->name }}</h3>
                            {!! $item->short !!}
                            <br><br>
                            <div class="product-cat-footer">
                                <div class="product-cat-price">Цена: <b>{{ number_format($item->price, 2) }}
                                        грн</b><br></div>
                                <div class="product-cat-buttons">
                                    <a class="btn btn-primary" href="{{ uri('product', ['id' => $item->id]) }}">Подробнее</a>
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

                    @if($category->countProducts > $category->products->count())
                        <div class="product-cat" style="text-align: center; display: flex">

                            <div style="margin: auto">
                                <a href="{{ uri('category', ['id' => $category->id]) }}">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/More_Icon_C.svg"
                                         alt="">
                                </a>

                                <br>

                                <a style="font-size: 25px" href="{{ uri('category', ['id' => $category->id]) }}">
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

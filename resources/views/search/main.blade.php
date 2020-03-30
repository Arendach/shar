@extends('layouts.main')

@section('content')

    <div class="container-fluid">
        <hr style="margin-top: 0">
    </div>

    <div class="container">
        @if($products->count())
            <div class="products-cat">
                @foreach($products as $item)
                    <div class="product-cat">
                        <a href="{{ $item->url }}">
                            <img class="lazy" src="" data-src="{{ $item->photo_min }}" alt="{{ $item->name }}">
                        </a>
                        <h2 class="product-name">{{ $item->name }}</h2>
                        <div class="product-cat-footer">
                            <div class="product-cat-price">
                                Цена: <b>{{ number_format($item->price) }} грн
                                </b>
                            </div>
                            <div class="product-cat-buttons">
                                <a class="btn btn-primary" href="{{ $item->url }}">
                                    Подробнее
                                </a>
                                <button data-data="{{ json_encode([
                                                'name' => $item->name,
                                                'price' => $item->price,
                                                'id' => $item->id,
                                                'photo' => $item->photo
                                                ]) }}"
                                        class="btn btn-primary to_cart"
                                >
                                    В корзину
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="centered">
                {{ $products->links() }}
            </div>
        @else
            <h4 class="centered">По вашему запросу ничего не найдено :(</h4>
        @endif
    </div>

@endsection('content')

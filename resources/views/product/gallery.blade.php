<style>
    .my-gallery {
        display: block;
    }

    .my-gallery figure {
        display: inline-block;
        height: 100px;
        margin: 3px;
    }

    .my-gallery figure img {
        height: 100px;
    }

    .my-gallery figcaption {
        display: none;
    }

    figure:first-child {
        width: 100%;
        height: 100%;
    }

    figure:first-child img {
        height: 100%;
        width: 100%;
    }

</style>

<div class="my-gallery">
    @php list($width_m, $height_m, $type_m, $attr_m) = getimagesize(public_path($product->getOriginal('photo'))) @endphp

    <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <a href="{{ $product->photo }}" itemprop="contentUrl" data-size="{{ $width_m . 'x' . $height_m }}">
            <img src="{{ $product->photo_min }}" itemprop="thumbnail" alt="{{ $product->photo_description }}">
        </a>
        <figcaption style="display: none;" itemprop="caption description">
            {{ $product->photo_description }}
        </figcaption>
    </figure>

    @foreach($product->images as $item)
        @php list($width_l, $height_l, $type_l, $attr_l) = getimagesize(public_path($item->getOriginal('path_large'))) @endphp

        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <a href="{{ $item->path_large }}" itemprop="contentUrl" data-size="{{ $width_l . 'x' . $height_l }}">
                <img src="{{ $item->path_min }}" itemprop="thumbnail" alt="{{ $item->description }}">
            </a>
            <figcaption itemprop="caption description">{{ $item->description }}</figcaption>
        </figure>
    @endforeach
</div>

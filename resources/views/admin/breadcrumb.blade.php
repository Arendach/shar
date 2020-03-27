<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ env('APP_NAME') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ url('admin') }}">Админка</a></li>
        @isset($breadcrumb)
            @foreach($breadcrumb as $item)
                @if (!$loop->last && $loop->count != 1)
                    <li class="breadcrumb-item">
                        <a href="{{ url($item['url']) }}">
                            {{ $item['name'] }}
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $item['name'] }}
                    </li>
                @endif
            @endforeach
        @endisset
    </ol>
</nav>
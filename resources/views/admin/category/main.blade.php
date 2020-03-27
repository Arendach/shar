@extends('layouts.admin')

@section('content')

    <script>
        var token = '{{ csrf_token() }}';
    </script>

    <div class="right form-group">
        <a href="{{ url('admin/category?section=create') }}" class="btn btn-primary">Новая категория</a>
    </div>

    <table class="table table-bordered">
        <tr>
            <td style="font-weight: bolder">Название</td>
            <td style="font-weight: bolder">Заголовок</td>
            <td style="font-weight: bolder">Ключевые слова</td>
            <td style="font-weight: bolder">Мета описание</td>
            <td style="font-weight: bolder">Приоритет</td>
            <td style="font-weight: bolder" class="action-2 centered">Действия</td>
        </tr>
        @foreach($categories as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->meta_title }}</td>
                <td>{{ $item->meta_keywords }}</td>
                <td>{{ $item->meta_description }}</td>
                <td>{{ $item->sort }}</td>
                <td class="action-2 centered">
                    <a href="{{ url('admin/category?section=update&id=' . $item->id) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <button data-id="{{ $item->id }}" class="to_archive btn btn-sm btn-danger">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </table>
@endsection('content')
@extends('layouts.admin')

@section('content')

    <script>
        var token = '{{ csrf_token() }}';
    </script>

    <table class="table table-bordered">
        <tr>
            <td>Название</td>
            <td>Ключевые слова</td>
            <td>Мета описание</td>
            <td class="action-1"></td>
        </tr>
        @forelse($categories as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->meta_keywords }}</td>
                <td>{{ $item->meta_description }}</td>
                <td class="action-1">
                    <button data-id="{{ $item->id }}" class="un_archive btn btn-sm btn-primary"
                            title="Вернуть из архива">
                        <i class="fa fa-rotate-left"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="centered">
                    Архив пуст
                </td>
            </tr>
        @endforelse    </table>

@endsection

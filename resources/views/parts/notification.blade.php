<div class="alert notification alert-{{ $notification['type'] ?? 'success' }} alert-dismissible fade show" role="alert">
    <strong>{{ $notification['title'] ?? 'Выполнено!' }}</strong> {!! $notification['message'] ?? 'Данные сохранены!' !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
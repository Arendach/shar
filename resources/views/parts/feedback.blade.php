<div data-toggle="modal" data-target="#feedback" class="feedback-open">
    <i class="fa fa-phone"></i>
    <span class="d-none d-sm-none d-md-none d-lg-inline d-xl-inline">Перезвоните мне</span>
</div>

<!-- Modal -->

<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartTitle">Перезвоните мне</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('feedback.create') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>
                            <i class="text-danger">*</i> Ваше имя
                        </label>
                        <input required class="form-control form-control-sm" name="name">
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="text-danger">*</i> Телефон
                        </label>
                        <input pattern="^[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$" required
                               class="form-control form-control-sm" name="phone">
                    </div>
                    <div class="form-group">
                        <label>Сообщение</label>
                        <textarea class="form-control form-control-sm" name="message"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <button class="btn btn-sm btn-primary">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

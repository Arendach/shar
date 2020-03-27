<style>

    span.file_select {
        display: block;
        border: 1px dashed #ccc;
        padding: 30px;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        color: #aaa;
    }

    label.file_select {
        display: block;
    }

    #file_name {
        font-size: 12px;
        color: #aaa;
    }
</style>

<div class="row">
    <div class="col-4">
        <form enctype="multipart/form-data" id="update_banner_image">

            <input type="hidden" name="action" value="update_photo">

            <div class="form-group">
                <label class="file_select">
                    <input style="display: none" type="file" name="file" accept="image/*">
                    <span class="file_select">Выбрать файл</span>
                </label>
            </div>

            <div id="file_name"></div>

            <div id="place_for_load"></div>

            <div class="form-group">
                <button class="btn btn-primary btn-sm btn-block">Сохранить</button>
            </div>

        </form>
    </div>

    <div class="col-8">
        @if(is_file(public_path(settings('layer.image'))))
            <a href="{{ asset(settings('layer.image')) }}">
                <img width="100%" src="{{ asset(settings('layer.image')) }}">
            </a>
        @else
            Фото не найдено
        @endif
    </div>
</div>

<hr>

<?php $section = 'layer'; ?>
<?php $data = Settings::getSection($section); ?>
@include('admin.settings.parts')


<script>
    $(document).ready(function () {
        var $body = $('body');

        $body.on('change', "input[type=file]", function () {

            var str = '';
            for (var i = 0; i < this.files.length; i++) {
                str += this.files[i].name + '<br>';
            }

            if (str == '')
                $("#file_name").html('').removeClass('form-group');
            else
                $("#file_name").html(str).addClass('form-group');
        });

        $body.on('submit', 'form#update_banner_image', function (event) {
            event.preventDefault();

            $('#place_for_load').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>' +
                '<span>Загрузка...</span>').toggleClass('form-group');

            var data = new FormData(this);

            $.ajax({
                type: 'post',
                url: url('admin/settings'),
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (answer) {
                    successHandler(answer);

                    $('#place_for_load').html('').toggleClass('form-group');
                },
                error: function (answer) {
                    errorHandler(answer);

                    $('#place_for_load').html('').toggleClass('form-group');
                }
            });

            return false;

        });
    });

</script>

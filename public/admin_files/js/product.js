$(document).ready(function () {
    var $body = $('body');

    $body.on('submit', 'form#create', function (event) {
        event.preventDefault();

        var data = $(this).serializeJSON();

        data.action = 'create';

        $.ajax({
            type: 'post',
            url: url('admin/product'),
            data: data,
            success: function (answer) {
                var answer = JSON.parse(answer);
                window.location.href = url('admin/product?section=update&id=' + answer.id + '&notification=created');
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('submit', 'form#update_main', function (event) {
        event.preventDefault();

        var data = $(this).serializeJSON();

        data.action = 'update_main';

        $.ajax({
            type: 'post',
            url: url('admin/product'),
            data: data,
            success: function (answer) {
                successHandler(answer, true);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('submit', 'form#update_other', function (event) {
        event.preventDefault();

        var data = $(this).serializeJSON();

        data.action = 'update_other';

        $.ajax({
            type: 'post',
            url: url('admin/product'),
            data: data,
            success: function (answer) {
                successHandler(answer, true);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('submit', 'form#update_photo', function (event) {
        event.preventDefault();


        var data = new FormData(this);

        $.ajax({
            url: url('admin/product'),
            type: 'POST',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });

    });

    $body.on('submit', 'form#add_photo', function (event) {
        event.preventDefault();

        $('#place_for_load').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>' +
            '<span>Загрузка...</span>').toggleClass('form-group');

        var data = new FormData(this);

        $.ajax({
            type: 'post',
            url: url('admin/product'),
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

    $body.on('change', "#photo_gallery input[type=file]", function () {

        var str = '';
        for (var i = 0; i < this.files.length; i++) {
            str += this.files[i].name + '<br>';
        }

        if (str == '')
            $("#file_names").html('').removeClass('form-group');
        else
            $("#file_names").html(str).addClass('form-group');
    });


    $body.on('change', "#photo input[type=file]", function () {

        var str = '';
        for (var i = 0; i < this.files.length; i++) {
            str += this.files[i].name + '<br>';
        }

        if (str == '')
            $("#file_name").html('').removeClass('form-group');
        else
            $("#file_name").html(str).addClass('form-group');
    });
});
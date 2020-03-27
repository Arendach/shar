$(document).ready(function () {

    var $body = $('body');

    $body.on('submit', 'form#update', function (event) {
        event.preventDefault();

        var data = $(this).serializeJSON();

        data.action = 'update';

        $.ajax({
            type: 'post',
            url: url('admin/category'),
            data: data,
            success: function (answer) {
                successHandler(answer, true);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });
    
    $body.on('submit', 'form#create', function (event) {
        event.preventDefault();

        var data = $(this).serializeJSON();

        data.action = 'create';

        $.ajax({
            type: 'post',
            url: url('admin/category'),
            data: data,
            success: function (answer) {
                var answer = JSON.parse(answer);
                window.location.href = url('admin/category?section=update&notification=created&id=' + answer.id)
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('click', '.to_archive', function () {
        var id = $(this).data('id');

        $.ajax({
            type: 'post',
            url: url('admin/category'),
            data: {
                action: 'to_archive',
                id: id,
                _token: token
            },
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('click', '.un_archive', function () {
        var id = $(this).data('id');

        $.ajax({
            type: 'post',
            url: url('admin/category'),
            data: {
                action: 'un_archive',
                id: id,
                _token: token
            },
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

});
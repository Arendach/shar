$(document).ready(function () {

    var $body = $('body');

    var width = $('.image-background').width();
    $('.image-background').height(width);

    var width_ = 0;
    $('header ul li').each(function () {
        width_ += $(this).width();
    });

    $body.on('submit', '[data-type="ajax"]', function (event) {
        event.preventDefault();
        var data = $(this).serializeJSON();
        var url = $(this).attr('action');
        var redirect_url = $(this).data('url');
        var success = $(this).data('success');

        var $form = $(this);
        $form.find('button').attr('disabled', 'disabled');

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            success: function (answer) {
                if (success == 'redirect') {
                    successHandler(answer, function () {
                        redirect(redirect_url);
                    });
                } else {
                    successHandler(answer);
                }
                $form.find('button').removeAttr('disabled');
            },
            error: function (answer, code, errThrown) {
                console.log(errThrown);
                console.log(code);
                if (code == 303) {
                    console.log('303 redirect');
                    return;
                }
                errorHandler(answer);
                $form.find('button').removeAttr('disabled');
            }
        });
    });

    $body.on('click', '[data-type="delete"]', function () {
        var id = $(this).data('id');
        var uri = $(this).data('uri');
        var action = $(this).data('action');
        var post = $(this).data('post');

        if (post !== undefined)
            var data = post + '&action=' + action;
        else
            var data = {id: id, action: action};

        delete_on_click(function () {
            $.ajax({
                type: 'post',
                url: uri,
                data: data,
                success: function (answer) {
                    successHandler(answer);
                },
                error: function (answer) {
                    errorHandler(answer);
                }
            });
        });
    });

    $body.on('click', '[data-type="get_form"]', function (event) {
        event.preventDefault();
        var uri = $(this).data('uri');
        var action = $(this).data('action');
        var post = $(this).data('post');
        var data = post == undefined ? 'action=' + action : post + '&action=' + action;

        $.ajax({
            type: 'post',
            url: uri,
            data: data,
            success: function (answer) {
                myModalOpen(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('click', '[data-type="ajax_request"]', function (event) {
        event.preventDefault();

        var uri = $(this).data('uri');
        var data = $(this).data('post');
        var action = $(this).data('action');

        data = data + '&action=' + action;

        $.ajax({
            type: 'post',
            url: uri,
            data: data,
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });


    $('[data-toggle=tooltip]').tooltip();

    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-pills a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });


    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 600);
        return false;
    });

    $("#feedback [name=phone]").inputmask({"mask": "999-999-99-99"});

    $body.on('submit', '#feedback form', function (event) {
        event.preventDefault();

        var data = $(this).serializeJSON();
        var $form = $(this);

        $.ajax({
            type: 'post',
            url: '/feedback',
            data: data,
            success() {
                $form.trigger('reset');
                $('#feedback').modal('hide');
                swal({
                    type: 'success',
                    title: 'Успешно!',
                    text: 'Ваше сообщение успешно отправлено! <br> Ждите звонка менеджера!',
                    html: true
                });
            },
            error() {
                swal('Ошибка!', 'Ваше сообщение не отправлено!', 'error');
            }
        })
    });

    $body.on('submit', 'form#search', function (event) {
        event.preventDefault();
        window.location.href = '/search/' + $(this).find('input').val();
    });

});
$(document).on('click', '[data-type="ajax_request"]', function (event) {
    event.preventDefault();

    let uri = $(this).data('uri')
    let data = $(this).data('post')
    let action = $(this).data('action')

    data = data + '&action=' + action

    $.ajax({
        type: 'post',
        url: uri,
        data: data,
        success(answer) {
            successHandler(answer)
        },
        error(answer) {
            errorHandler(answer)
        }
    });
});

$(document).ready(function () {
    var $body = $('body');

    $('.notification').on('closed.bs.alert', function () {
        if ($('.notification').length == 0) {
            $('#notification_hr').remove();
        }
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

    $body.on('click', '[data-type="exit"]', function (event) {
        event.preventDefault()
        let token = $(this).data('token')

        $.ajax({
            type: 'post',
            url: '/admin/user',
            data: {
                action: 'exit',
                _token: token
            },
            success: function (answer) {
                window.location.reload()
            },
            error: function (answer) {
                errorHandler(answer)
            }
        })
    })

    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-pills a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    $('.nav-pills a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });

    $('[data-toggle="tooltip"]').tooltip();
});
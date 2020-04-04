function delete_on_click(param, func) {
    swal({
        title: param.title !== undefined ? param.title : 'Удалить?',
        text: param.text !== undefined ? param.text : 'Данное действие отменить будет нельзя?',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: param.confirmButtonText !== undefined ? param.confirmButtonText : 'Да, я хочу удалить!',
        closeOnConfirm: false
    }, func !== undefined ? func : param);
}

function error_popup(err) {
    var e = err === undefined ? 'Фатальная ошибка!' : err;
    swal({
        type: 'error',
        text: e,
        title: 'Ошибка!'
    });
}

function success_popup(mess) {
    var e = mess === undefined ? 'Удачно выполнено!' : mess;
    swal({
        type: 'success',
        text: e,
        title: 'Выполнено!'
    });
}

window.errorHandler = function (response) {
    try {
        let answer = response.responseJSON
        let message = answer.message !== undefined ? answer.message : 'Неизвестная ошибка!';
        swal({
            type: 'error',
            text: message,
            title: 'Ошибка!',
            html: true
        });
    } catch (err) {
        swal({
            type: 'error',
            text: response.responseText,
            title: 'Ошибка!',
            html: true
        });
    }
}

window.successHandler = function (response, func) {
    try {
        if (func === undefined) {
            func = function () {
                location.reload();
            };
        } else if (func === true) {
            func = function () {
                swal.close();
            };
        }

        let message = response.hasOwnProperty('message') ? response.message : 'Данные сохранены!';

        swal({
            type: 'success',
            text: message,
            title: 'Выполнено!',
            closeOnConfirm: false
        }, func);

    } catch (err) {
        swal({
            type: 'error',
            text: response,
            title: 'Ошибка!',
            html: true
        });
    }
}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Авторизация</title>
</head>
<body>

<div class="container">
    <div class="login-block">
        <div class="login-head">
            Авторизация
        </div>

        <form action="{{ url('admin/login') }}" data-type="login">

            <input type="hidden" name="action" value="login">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label>Логин</label>
                <input autofocus required class="form-control" name="login">
            </div>

            <div class="form-group">
                <label>Пароль</label>
                <input required class="form-control" name="password" type="password">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <button class="btn btn-primary">Авторизация</button>
            </div>

        </form>
    </div>
</div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/jquery.serialize_json.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/components/sweetalert/sweetalert.js') }}"></script>
<script src="{{ asset('js/components/sweetalert/sweetalert_functions.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

<script>
    $(document).on('submit', '[data-type="login"]', function (event) {
        event.preventDefault()

        let data = new FormData(this)
        let action = $(this).attr('action')

        $.ajax({
            type: 'post',
            url: action,
            data: data,
            processData: false,
            contentType: false,
            success: function (answer) {
                location.reload()
            },
            error: function (answer) {
                errorHandler(answer)
            }
        })
    })
</script>

</body>
</html>
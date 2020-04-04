<?php

/**
 * @param $array
 * @return array
 * @deprecated
 */
function get_keys($array)
{
    $temp = [];

    foreach ($array as $k => $v) $temp[] = $k;

    return $temp;
}

/**
 * @param $part
 * @param string $parameters
 * @return string
 * @deprecated
 */
function uri($part, $parameters = '')
{
    if (preg_match('/^\//', $part))
        $part = preg_replace('/^(\/)/', '', $part);

    if (is_array($parameters))
        return env('APP_URL') . '/' . $part . parameters($parameters);
    else
        return env('APP_URL') . '/' . $part;
}

/**
 * @deprecated
 * @param $str
 * @return string
 */
function my_crypt($str)
{
    return md5(md5($str));
}


/**
 * @param $array
 * @return bool|stdClass
 * @deprecated
 */
function get_object($array)
{
    if (!is_array($array) && !is_object($array)) {
        return false;
    } else {
        $result = new stdClass();
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $result->$k = get_object($v);
            } else {
                $result->$k = $v;
            }
        }
        return $result;
    }
}

/**
 * @param $object
 * @return array|bool
 * @deprecated
 */
function get_array($object)
{
    if (!is_object($object) && !is_array($object)) {
        return false;
    } else {
        $result = [];
        foreach ($object as $k => $v) {
            if (is_array($v)) {
                $result[$k] = get_array($v);
            } else {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}

/**
 * @param $param
 * @return int
 * @deprecated
 */
function my_count($param)
{
    if (is_object($param)) {
        $tmp = (array)$param;
        $result = count($tmp);
    } elseif (is_array($param)) {
        $result = count($param);
    } else {
        $result = 0;
    }

    return (int)$result;
}

/**
 * @param string $key
 * @param bool $assoc
 * @return array|bool|float|int|object|string
 * @deprecated
 */
function get($key = 'get_all_in_object', $assoc = false)
{
    if ($key == 'get_all_in_object') {
        if ($assoc === true) {
            $i = 0;
            $params = [];
            foreach ($_GET as $k => $v) {
                $params[$i][$k] = $v;
                $i++;
            }
            return $params;
        } else {
            return get_object($_GET);
        }
    } elseif ($key == 'page') {
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            return abs(intval($_GET['page']));
        } else
            return 1;
    } else {
        if (isset($_GET[$key])) {
            if (is_numeric($_GET[$key]))
                return (int)htmlspecialchars($_GET[$key]);
            else
                return (string)htmlspecialchars($_GET[$key]);
        } else
            return false;
    }
}

/**
 * @param string $key
 * @return mixed|null
 * @deprecated
 */
function post($key = '')
{
    if ($key == '') {
        return $_POST;
    } else {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        } else {
            return null;
        }
    }
}

/**
 * @param $status - Код статуса http
 * @deprecated
 */
function http_status($status)
{
    $statuses = [
        /**
         * 1xx: Informational (информационные)
         */
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',

        /**
         * 2xx: Success (успешно)
         */
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted', // принято
        203 => 'Non-Authoritative Information', // информация не авторитетна
        204 => 'No Content', // нет содержимого
        205 => 'Reset Content', // сбросить содержимое
        206 => 'Partial Content', // частичное содержимое
        207 => 'Multi-Status', // многостатусный
        208 => 'Already Reported', // уже сообщалось
        226 => 'IM Used', // использовано IM

        /**
         * 3xx: Redirection (перенаправление)
         */
        300 => 'Multiple Choices', // множество выборов
        301 => 'Moved Permanently', // перемещено навсегда
        302 => 'Moved Temporarily', // перемещено временно
        303 => 'See Other', // смотреть другое
        304 => 'Not Modified', // не изменялось
        305 => 'Use Proxy', // использовать прокси
        306 => '', // зарезервировано (код использовался только в ранних спецификациях)[7];
        307 => 'Temporary Redirect', //' временное перенаправление
        308 => 'Permanent Redirect', // постоянное перенаправление.

        /**
         * 4xx: Client Error (ошибка клиента)
         */
        400 => 'Bad Request', // плохой, неверный запрос
        401 => 'Unauthorized', // не авторизован
        402 => 'Payment Required', // необходима оплата
        403 => 'Forbidden', // запрещено
        404 => 'Not Found', // не найдено
        405 => 'Method Not Allowed', // метод не поддерживается
        406 => 'Not Acceptable', // неприемлемо
        407 => 'Proxy Authentication Required', // необходима аутентификация прокси
        408 => 'Request Timeout', // истекло время ожидания
        409 => 'Conflict', // конфликт
        410 => 'Gone', // удалён
        411 => 'Length Required', // необходима длина
        412 => 'Precondition Failed', // условие ложно
        413 => 'Payload Too Large', // полезная нагрузка слишком велика
        414 => 'URI Too Long', // URI слишком длинный
        415 => 'Unsupported Media Type', // неподдерживаемый тип данных
        416 => 'Range Not Satisfiable', // диапазон не достижим
        417 => 'Expectation Failed', // ожидание не удалось
        418 => 'I’m a teapot', // я — чайник
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity', // необрабатываемый экземпляр
        423 => 'Locked', // заблокировано
        424 => 'Failed Dependency', // невыполненная зависимость
        426 => 'Upgrade Required', // необходимо обновление
        428 => 'Precondition Required', // необходимо предусловие
        429 => 'Too Many Requests', // слишком много запросов
        431 => 'Request Header Fields Too Large', // поля заголовка запроса слишком большие
        444 => '', //Закрывает соединение без передачи заголовка ответа. Нестандартный код
        449 => 'Retry With', //' повторить с
        451 => 'Unavailable For Legal Reasons', // недоступно по юридическим причинам

        /**
         * 5xx: Server Error (ошибка сервера)
         */
        500 => 'Internal Server Error', // внутренняя ошибка сервера
        501 => 'Not Implemented', // не реализовано
        502 => 'Bad Gateway', // плохой, ошибочный шлюз
        503 => 'Service Unavailable', // сервис недоступен
        504 => 'Gateway Timeout', // шлюз не отвечает
        505 => 'HTTP Version Not Supported', // версия HTTP не поддерживается
        506 => 'Variant Also Negotiates', // вариант тоже проводит согласование
        507 => 'Insufficient Storage', // переполнение хранилища
        508 => 'Loop Detected', // обнаружено бесконечное перенаправление
        509 => 'Bandwidth Limit Exceeded', // исчерпана пропускная ширина канала
        510 => 'Not Extended', // не расширено
        511 => 'Network Authentication Required', // требуется сетевая аутентификация
        520 => 'Unknown Error', // неизвестная ошибка
        521 => 'Web Server Is Down', // веб-сервер не работает
        522 => 'Connection Timed Out', // соединение не отвечает
        523 => 'Origin Is Unreachable', // источник недоступен
        524 => 'A Timeout Occurred', // время ожидания истекло
        525 => 'SSL Handshake Failed', // квитирование SSL не удалось
        526 => 'Invalid SSL Certificate', // недействительный сертификат SSL
    ];
    if (isset($statuses[$status]))
        header('HTTP/1.1 ' . $status . ' ' . $statuses[$status]);
}

/**
 * @param $status - http код відповіді сервера
 * @param bool $messageOrArray - Повідомлення або масив,
 * який буде передано клієнту в виді JSON - строки
 * @deprecated
 */
function res($status, $messageOrArray = false)
{
    http_status($status);
    if (is_array($messageOrArray))
        echo json_encode($messageOrArray);
    elseif (is_string($messageOrArray))
        echo json_encode(['message' => $messageOrArray]);
    exit;
}

/**
 * @param $array
 * @param $key
 * @param string $res
 * @return array|bool|stdClass
 * @deprecated
 */
function map_by($array, $key, $res = 'array')
{
    $new = [];
    $array = get_object($array);
    foreach ($array as $item) {
        $new[$item->{$key}] = $item;
    }

    return $res == 'array' ? $new : get_object($new);
}

/**
 * @param $array
 * @param int $count
 * @param string $res
 * @return array|object
 * @deprecated
 */
function group_array($array, $count = 3, $res = 'object')
{
    $temp = [];

    $i = 0;
    $i2 = 0;
    foreach ($array as $item) {
        $temp[$i2][] = $item;
        if ($i == $count - 1) {
            $i = 0;
            $i2++;
        } else {
            $i++;
        }
    }

    return $res == 'object' ? (object)$temp : (array)$temp;
}
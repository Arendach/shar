<?php

/**
 * @param $array
 * @return bool|object
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
 * @param $var
 */
function d($var)
{
    echo '<pre style="z-index: 9999999;">';
    print_r($var);
    echo '</pre>';
    exit;
}

/**
 * Очищення папки від файлів
 * @param $dir
 */
function dir_clean($dir)
{
    dir_delete($dir);
    mkdir($dir);
}

/**
 * Видалення папки з файлами
 * @param $dir
 */
function dir_delete($dir)
{
    if (!is_dir($dir)) {
        mkdir($dir);
    }
    if (substr($dir, strlen($dir) - 1, 1) != '/') {
        $dir .= '/';
    }
    $files = glob($dir . '*', GLOB_MARK);
    foreach ($files as $file) {
        is_dir($file) ? dir_delete($file) : unlink($file);
    }
    rmdir($dir);
}

/**
 * @param $int - 1-12
 * @return string - назва місяця на укрїнській
 */
function int_to_month($int, $v = 0)
{
    if ($int == '1' || $int == '01') {
        return $v ? 'Січня' : 'Січень';
    } elseif ($int == '2' || $int == '02') {
        return $v ? 'Лютого' : 'Лютий';
    } elseif ($int == '3' || $int == '03') {
        return $v ? 'Березня' : 'Березень';
    } elseif ($int == '4' || $int == '04') {
        return $v ? 'Квітня' : 'Квітень';
    } elseif ($int == '5' || $int == '05') {
        return $v ? 'Травня' : 'Травень';
    } elseif ($int == '6' || $int == '06') {
        return $v ? 'Червня' : 'Червень';
    } elseif ($int == '7' || $int == '07') {
        return $v ? 'Липня' : 'Липень';
    } elseif ($int == '8' || $int == '08') {
        return $v ? 'Серпня' : 'Серпень';
    } elseif ($int == '9' || $int == '09') {
        return $v ? 'Вересня' : 'Вересень';
    } elseif ($int == '10') {
        return $v ? 'Жовтня' : 'Жовтень';
    } elseif ($int == '11') {
        return $v ? 'Листопада' : 'Листопад';
    } elseif ($int == '12') {
        return $v ? 'Грудня' : 'Грудень';
    } else {
        return '';
    }
}

/**
 * @param $date - Y-m-d
 * @return null|string  - День тижня на українській
 */
function date_to_day($date)
{
    $day = date('D', strtotime($date));
    if ($day == 'Fri') {
        return 'Пятниця';
    } elseif ($day == 'Sat') {
        return 'Субота';
    } elseif ($day == 'Sun') {
        return 'Неділя';
    } elseif ($day == 'Mon') {
        return 'Понеділок';
    } elseif ($day == 'Tue') {
        return 'Вівторок';
    } elseif ($day == 'Wed') {
        return 'Середа';
    } elseif ($day == 'Thu') {
        return 'Четвер';
    }
    return null;
}

/**
 * @param $status - Код статуса http
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
 * @param array $parameters - Масив виду [key => value,....]
 * @return bool|string - строка виду ?key=value...
 */
function parameters(array $parameters)
{
    $string = '?';
    foreach ($parameters as $key => $value)
        $string .= $key . '=' . $value . '&';
    return substr($string, 0, strlen($string) - 1);
}

/**
 * @param $num
 * @return string
 */
function num2str($num)
{
    $nul = 'нуль';
    $ten = array(
        array('', 'один', 'два', 'три', 'чотири', 'пять', 'шість', 'сім', 'вісім', 'девять'),
        array('', 'одна', 'дві', 'три', 'чотири', 'пять', 'шість', 'сім', 'вісім', 'девять'),
    );
    $a20 = array('десять', 'одиннадцать', 'дванадцать', 'тринадцать', 'чотирнадцать', 'пятнадцать', 'шістнадцать', 'сімнадцать', 'вісімнадцать', 'девятнадцять');
    $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятдесят', 'шістьдесят', 'сімдесят', 'вісімьдесят', 'девяносто');
    $hundred = array('', 'сто', 'двісті', 'триста', 'чотириста', 'пятсот', 'шістсот', 'сімсот', 'вісімсот', 'девятсот');
    $unit = array( // Units
        array('копійка', 'копійки', 'копійок', 1),
        array('гривня', 'гривні', 'гривнів', 0),
        array('тисяча', 'тисячі', 'тисяч', 1),
        array('мільйон', 'мільйони', 'мільйонів', 0),
        array('мільярд', 'мільярди', 'мільярдів', 0),
    );
    //
    list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub) > 0) {
        foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit) - $uk - 1; // unit key
            $gender = $unit[$uk][3];
            list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
            else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk > 1) $out[] = morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
        } //foreach
    } else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
    $out[] = $kop . ' ' . morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
}

/**
 * @param $n
 * @param $f1
 * @param $f2
 * @param $f5
 * @return mixed
 */
function morph($n, $f1, $f2, $f5)
{
    $n = abs(intval($n)) % 100;
    if ($n > 10 && $n < 20) return $f5;
    $n = $n % 10;
    if ($n > 1 && $n < 5) return $f2;
    if ($n == 1) return $f1;
    return $f5;
}

/**
 * @param $date
 * @return string
 */
function diff_for_humans($date)
{
    \Carbon\Carbon::setLocale('uk');
    $d = date_parse($date);
    $parts = ['year', 'month', 'day', 'hour', 'minute', 'second'];
    foreach ($parts as $item)
        if (!isset($d[$item]) || empty($d[$item]))
            $d[$item] = '00';

    return \Carbon\Carbon::create(
        $d['year'],
        $d['month'],
        $d['day'],
        $d['hour'],
        $d['minute'],
        $d['second'],
        'Europe/Kiev')
        ->diffForHumans();
}

/**
 * @param bool $string
 * @return string
 */
function date_for_humans($string = false)
{
    if ($string == false) {
        return date('d') . ' ' . int_to_month(date('m'), 1) . ' ' . date('Y');
    } else {
        $d = date_parse($string);
        return $d['day'] . ' ' . int_to_month($d['month'], 1) . ' ' . $d['year'];
    }
}

/**
 * @param $phone
 * @return string
 */
function get_number_world_format($phone)
{
    if (preg_match('/\+38[0-9]{10,10}/', $phone)) {
        return $phone;
    }

    if (preg_match('@38[0-9]{10,10}@', $phone)) {
        return '+' . $phone;
    }

    if (preg_match('@[0-9]{10,10}@', $phone)) {
        return '+38' . $phone;
    }

    if (preg_match('@[0-9]{9,9}@', $phone)) {
        return '+380' . $phone;
    }

    return 'error!!';
}

/**
 * @return string
 */
function rand32()
{
    return md5(md5(rand(1000, 9999) . date('YmdHis') . rand(10000, 99999)));
}

/**
 * @param $str
 * @return mixed
 */
function p2s($str)
{
    return str_replace('.', '/', $str);
}

/**
 * @param $date
 * @return bool
 */
function is_online($date)
{
    return time() - $date < 300 ? true : false;
}

function map_by($array, $key, $res = 'array')
{
    $new = [];
    $array = get_object($array);
    foreach ($array as $item) {
        $new[$item->{$key}] = $item;
    }

    return $res == 'array' ? $new : get_object($new);
}

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

function params(array $parameters)
{
    return preg_replace('@^\?@', '', parameters($parameters));
}

function get_keys($array)
{
    $temp = [];

    foreach ($array as $k => $v) $temp[] = $k;

    return $temp;
}

function uri($part, $parameters = '')
{
    if (preg_match('/^\//', $part))
        $part = preg_replace('/^(\/)/', '', $part);

    if (is_array($parameters))
        return env('APP_URL') . '/' . $part . parameters($parameters);
    else
        return env('APP_URL') . '/' . $part;
}

function can($key = -1)
{
    if ($key == -1)
        if (user()->access == -1)
            return true;
        else
            return false;
    elseif (is_string($key))
        return is_array(user()->access) ? (boolean)in_array($key, user()->access) : true;
    else
        return false;
}

function cannot($key)
{
    return !can($key);
}

function my_crypt($str)
{
    return md5(md5($str));
}

function settings($key, $default = '')
{
    return \Settings::get($key, $default);
}

function user($id = 0)
{
    if ($id == 0) {
        return $_SESSION['user'];
    } else {
        return \App\Models\User::find($id);
    }
}

function create_folder_if_not_exists($name)
{
    if (!is_dir(base_path($name)))
        mkdir(base_path($name), 0777, true);
}


function my_file_size($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

function is_auth()
{
    if (isset($_SESSION['is_auth']))
        return $_SESSION['is_auth'];

    return false;
}

function send_email($from, $to, $txt)
{
    $subject = "Оповещение shar.kiev.ua";
    $headers = "From: <$from> \r\n";
    $headers .= "MIME-Version: 1.0 \r\n";
    $headers .= "Content-type:text/html;charset=UTF-8 \r\n";

    mail($to, $subject, $txt, $headers);
}

function send_sms($phone, $message, $log = '')
{
    if (settings('sms.api_key') != '') {
        $api = new \Mobizon\MobizonApi(['apiKey' => settings('sms.api_key')]);

        $parameters = [
            'recipient' => get_number_world_format($phone),
            'text' => trim($message),
            'from' => settings('sms.from')
        ];

        if ($api->call('message', 'sendSMSMessage', $parameters)) {
            if ($log != '') {
                $parameters['date'] = date('Y-m-d H:i:s');
                $parameters['comment'] = $log;
                \DB::table('sms_log')->insert($parameters);
            }
            return true;
        }
    }

    return false;
}

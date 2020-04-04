<?php


/**
 * @param $int
 * @param int $v
 * @return string
 */
function int_to_month($int, $v = 0): string
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
function date_to_day($date): ?string
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
 * @param $date
 * @return string
 * @deprecated
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

<?php

use App\Models\SmsLog;
use Mobizon\MobizonApi;

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
 * @param string $phone
 * @return string|null
 */
function get_number_world_format(string $phone): ?string
{
    if (preg_match('/\+38[0-9]{10}/', $phone)) {
        return $phone;
    }

    if (preg_match('@38[0-9]{10}@', $phone)) {
        return "+$phone";
    }

    if (preg_match('@[0-9]{10}@', $phone)) {
        return "+38$phone";
    }

    if (preg_match('@[0-9]{9}@', $phone)) {
        return "+380$phone";
    }

    return null;
}

/**
 * @return string
 */
function rand32(): string
{
    return md5(md5(rand(1000, 9999) . date('YmdHis') . rand(10000, 99999)));
}

/**
 * @param string $str
 * @return string
 */
function p2s(string $str): string
{
    return str_replace('.', '/', $str);
}

/**
 * @param array $parameters
 * @return string
 */
function params(array $parameters): string
{
    return trim(parameters($parameters), '?');
}

/**
 * @param string $key
 * @param string $default
 * @return mixed|string
 */
function settings(string $key, $default = '')
{
    return \Settings::get($key, $default);
}

/**
 * @param $from
 * @param $to
 * @param $txt
 */
function send_email($from, $to, $txt)
{
    $subject = "Оповещение shar.kiev.ua";
    $headers = "From: <$from> \r\n";
    $headers .= "MIME-Version: 1.0 \r\n";
    $headers .= "Content-type:text/html;charset=UTF-8 \r\n";

    mail($to, $subject, $txt, $headers);
}

/**
 * @param $phone
 * @param $message
 * @param string $log
 * @return bool
 * @throws \Mobizon\Mobizon_ApiKey_Required
 * @throws \Mobizon\Mobizon_Curl_Required
 * @throws \Mobizon\Mobizon_Error
 * @throws \Mobizon\Mobizon_Http_Error
 * @throws \Mobizon\Mobizon_OpenSSL_Required
 * @throws \Mobizon\Mobizon_Param_Required
 */
function send_sms(string $phone, string $message, ?string $log = null): bool
{
    if (settings('sms.api_key') != '') {
        $api = new MobizonApi(settings('sms.api_key'), 'api.mobizon.ua');

        $parameters = [
            'recipient' => get_number_world_format($phone),
            'text'      => trim($message),
            'from'      => settings('sms.from')
        ];

        try {
            if ($api->call('message', 'sendSMSMessage', $parameters)) {
                if ($log) {
                    $parameters['date'] = date('Y-m-d H:i:s');
                    $parameters['comment'] = $log;
                    SmsLog::insert($parameters);
                }
                return true;
            }
        } catch (Exception $exception){
            Log::error($exception->getMessage());
        }
    }

    return false;
}

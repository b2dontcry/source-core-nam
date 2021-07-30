<?php

use Modules\UserAndPermission\Helpers\NName;
use Modules\UserAndPermission\Helpers\NResponse;

if (! function_exists('human_name')) {
    function human_name($fullName, $format = NName::LAST_FIRST)
    {
        return NName::of($fullName)->format($format);
    }
}

if (! function_exists('nRes')) {
    function nRes($data = null, $message = 'Success.', $code = 200)
    {
        $res = new NResponse();

        if (is_null($data)) {
            return $res;
        }

        return $res->response($data, $message, $code);
    }
}

if (! function_exists('queryStringToArray')) {
    /**
     * Chuyển chuỗi URL hoặc query string sang mảng chứa các tham số.
     *
     * @param  string  $string
     * @return array
     */
    function queryStringToArray($string = '')
    {
        if (empty($string)) {
            return [];
        }

        if (filter_var($string, FILTER_VALIDATE_URL)) {
            $string = (string) parse_url($string, PHP_URL_QUERY);
        }

        if (preg_match('/(.+=.*){1,}/', $string)) {
            parse_str($string, $result);
        } else {
            $result = [];
        }

        return $result;
    }
}

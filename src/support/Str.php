<?php

/*
 * This file is part of the pkg6/paypal
 *
 * (c) pkg6 <https://github.com/pkg6>
 *
 * (L) Licensed <https://opensource.org/license/MIT>
 *
 * (A) zhiqiang <https://www.zhiqiang.wang>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace pkg6\paypal\support;

use GuzzleHttp\Utils;

class Str
{
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param int $length
     *
     * @return string
     */
    public static function random($length = 16)
    {
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytesSize = (int) ceil($size / 3) * 3;
            $bytes = random_bytes($bytesSize);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * Determine if a given value is valid JSON.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isJson($value): bool
    {
        if ( ! is_string($value)) {
            return false;
        }

        if (function_exists('json_validate')) {
            return json_validate($value, 512);
        }

        try {
            Utils::jsonDecode($value, true, 512, 4194304);
        } catch (\JsonException $jsonException) {
            return false;
        }

        return true;
    }
}

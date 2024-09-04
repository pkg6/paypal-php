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

namespace pkg6\paypal;

use pkg6\paypal\contracts\CodeInterface;

/**
 * Class LocaleCode.
 *
 * @author zhiqiang
 *
 * @see https://developer.paypal.com/api/rest/reference/locale-codes/
 * @see Code
 */
final class LocaleCode implements CodeInterface
{
    const EN_US = 'en_US';
    const FR_XC = 'fr_XC';
    const ES_XC = 'es_XC';
    const ZH_XC = 'zh_XC';

    const codeText = [
        LocaleCode::EN_US => LocaleCode::EN_US,
        LocaleCode::FR_XC => LocaleCode::FR_XC,
        LocaleCode::ES_XC => LocaleCode::ES_XC,
        LocaleCode::ZH_XC => LocaleCode::ZH_XC,
    ];

    public static function url()
    {
        return "https://developer.paypal.com/api/rest/reference/locale-codes/";
    }

    public static function codes()
    {
        return array_keys(self::codeText);
    }
}

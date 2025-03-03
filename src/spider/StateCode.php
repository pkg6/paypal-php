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

namespace pkg6\paypal\spider;

use pkg6\paypal\contracts\CodeInterface;

/**
 * Class StateCode.
 *
 * @author zhiqiang
 *
 * @see https://developer.paypal.com/api/rest/reference/state-codes/
 * @see Code
 */
class StateCode implements CodeInterface
{
    //TODO
    const codeText = [];
    public static function url()
    {
        return "https://developer.paypal.com/api/rest/reference/state-codes/";
    }

    public static function codes()
    {
        return [];
    }
}

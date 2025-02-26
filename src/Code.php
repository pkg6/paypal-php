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

use pkg6\paypal\spider\CountryCode;
use pkg6\paypal\spider\CurrencyCode;
use pkg6\paypal\spider\LocaleCode;
use pkg6\paypal\spider\Spider;
use pkg6\paypal\spider\StateCode;

class Code
{

    /**
     * @return array
     *
     * @see https://developer.paypal.com/api/rest/reference/country-codes/
     *
     * @throws \Exception
     */
    public function readCountry()
    {
        return  Spider::readByClass(CountryCode::class);
    }

    /**
     * @return array
     *
     * @see https://developer.paypal.com/api/rest/reference/currency-codes/
     *
     * @throws \Exception
     */
    public function readCurrency()
    {
        return  Spider::readByClass(CurrencyCode::class);
    }

    /**
     * @return array
     *
     * @see https://developer.paypal.com/api/rest/reference/locale-codes/
     *
     * @throws \Exception
     */
    public function readLocale()
    {
        return  Spider::readByClass(LocaleCode::class);
    }

    /**
     * @return array
     *
     * @see https://developer.paypal.com/api/rest/reference/state-codes/
     *
     * @throws \Exception
     */
    public function readState()
    {
        return  Spider::readByClass(StateCode::class);
    }
}

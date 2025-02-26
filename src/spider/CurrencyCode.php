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
 * Class CurrencyCode.
 *
 * @author zhiqiang
 *
 * @see https://developer.paypal.com/api/rest/reference/currency-codes/
 * @see Code
 */
class CurrencyCode implements CodeInterface
{
    const AUD = 'AUD';
    const BRL = 'BRL';
    const CAD = 'CAD';
    const CNY = 'CNY';
    const CZK = 'CZK';
    const DKK = 'DKK';
    const EUR = 'EUR';
    const HKD = 'HKD';
    const HUF = 'HUF';
    const ILS = 'ILS';
    const JPY = 'JPY';
    const MYR = 'MYR';
    const MXN = 'MXN';
    const TWD = 'TWD';
    const NZD = 'NZD';
    const NOK = 'NOK';
    const PHP = 'PHP';
    const PLN = 'PLN';
    const GBP = 'GBP';
    const RUB = 'RUB';
    const SGD = 'SGD';
    const SEK = 'SEK';
    const CHF = 'CHF';
    const THB = 'THB';
    const USD = 'USD';

    const codeText = [
        self::AUD => 'Australian dollar',
        self::BRL => 'Brazilian real',
        self::CAD => 'Canadian dollar',
        self::CNY => 'Chinese Renminbi',
        self::CZK => 'Czech koruna',
        self::DKK => 'Danish krone',
        self::EUR => 'Euro',
        self::HKD => 'Hong Kong dollar',
        self::HUF => 'Hungarian forint',
        self::ILS => 'Israeli new shekel',
        self::JPY => 'Japanese yen',
        self::MYR => 'Malaysian ringgit',
        self::MXN => 'Mexican peso',
        self::TWD => 'New Taiwan dollar',
        self::NZD => 'New Zealand dollar',
        self::NOK => 'Norwegian krone',
        self::PHP => 'Philippine peso',
        self::PLN => 'Polish złoty',
        self::GBP => 'Pound sterling',
        self::RUB => 'Russian ruble',
        self::SGD => 'Singapore dollar',
        self::SEK => 'Swedish krona',
        self::CHF => 'Swiss franc',
        self::THB => 'Thai baht',
        self::USD => 'United States dollar',
    ];

    public static function codes()
    {
        return array_keys(self::codeText);
    }

    public static function url()
    {
        return "https://developer.paypal.com/api/rest/reference/currency-codes/";
    }
}

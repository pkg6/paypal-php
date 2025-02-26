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
use pkg6\paypal\support\Str;

class Spider
{
    /**
     * @var mixed
     */
    public static $path = "";

    /**
     * @var string[]
     */
    protected static $codeJsonFile = [
        CountryCode::class => [
            'name' => 'country.json',
            'method' => 'table',
        ],
        CurrencyCode::class => [
            'name' => 'currency.json',
            'method' => 'table',
        ],
        LocaleCode::class => [
            'name' => 'locale.json',
            'method' => 'table',
        ],
        StateCode::class => [
            'name' => 'state.json',
            'method' => 'tables',
        ],
    ];

    public static function getSavePath()
    {
        if (empty(self::$path)) {
            return __DIR__ . "/../../data";
        }

        return self::$path;
    }
    /**
     *  重新爬去数据保存在本地.
     *
     * @return array
     *
     * @throws \Exception
     *
     * @version ^4.2
     *
     * @see https://querylist.cc/
     */
    public static function spider($force = false)
    {
        $ret = [];
        /**
         * @var CodeInterface $class ;
         */
        foreach (self::$codeJsonFile as $class => $codeJsonFile) {
            $filename = self::filename($class);
            if (file_exists($filename) && ! $force) {
                continue;
            }
            $method = self::method($class);
            $data = CodeTable::$method($class::url());
            if ( ! empty($data)) {
                $ret[$class] = file_put_contents($filename, Str::json_encode($data));
            }
        }
        return $ret;
    }

    /**
     * @param $class
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function filename($class)
    {
        if ( ! Str::endsWith(self::getSavePath(), DIRECTORY_SEPARATOR)) {
            self::$path = self::getSavePath() . DIRECTORY_SEPARATOR;
        }
        if (isset(self::$codeJsonFile[$class]['name'])) {
            return self::$path . self::$codeJsonFile[$class]['name'];
        }
        throw new \Exception("class not found");
    }

    /**
     * @param $class
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function method($class)
    {
        if (isset(self::$codeJsonFile[$class]['method'])) {
            return self::$codeJsonFile[$class]['method'];
        }
        throw new \Exception("class not found");
    }

    /**
     * @param $class
     *
     * @return array
     *
     * @throws \Exception
     */
    public static function readByClass($class)
    {
        $filename = self::filename($class);

        return json_decode(file_get_contents($filename), true);
    }
}

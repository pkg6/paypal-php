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

use pkg6\paypal\contract\CodeInterface;
use pkg6\paypal\spider\CodeTable;
use pkg6\paypal\support\Str;

class Code
{

    /**
     * @var mixed
     */
    protected $path;

    /**
     * @var string[]
     */
    protected $codeJsonFile = [
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

    /**
     * @param string $path
     */
    public function __construct($path = "")
    {
        $path = $path ?: __DIR__ . "/../data";
        $this->path = $path;
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
    public function spider($force = false)
    {
        $ret = [];
        /**
         * @var CodeInterface $class ;
         */
        foreach ($this->codeJsonFile as $class => $codeJsonFile) {
            $filename = $this->filename($class);
            if (file_exists($filename) && ! $force) {
                continue;
            }
            $method = $this->method($class);
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
    public function method($class)
    {
        if (isset($this->codeJsonFile[$class]['method'])) {
            return $this->codeJsonFile[$class]['method'];
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
    public function filename($class)
    {
        if ( ! Str::endsWith($this->path, DIRECTORY_SEPARATOR)) {
            $this->path = $this->path . DIRECTORY_SEPARATOR;
        }
        if (isset($this->codeJsonFile[$class]['name'])) {
            return $this->path . $this->codeJsonFile[$class]['name'];
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
    public function key($class)
    {
        if (isset($this->codeJsonFile[$class]['key'])) {
            return $this->codeJsonFile[$class]['key'];
        }
        throw new \Exception("class not found");
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function countryAll()
    {
        return $this->readByClass(CountryCode::class);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function currencyAll()
    {
        return $this->readByClass(CurrencyCode::class);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function localeAll()
    {
        return $this->readByClass(LocaleCode::class);
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function stateAll()
    {
        return $this->readByClass(StateCode::class);
    }

    /**
     * @param $class
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function readByClass($class)
    {
        $filename = $this->filename($class);

        return json_decode(file_get_contents($filename), true);
    }

}

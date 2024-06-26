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

use QL\Dom\Elements;
use QL\QueryList;

class CodeTable
{

    protected static function strstr($str)
    {
        return strtr($str, [' ' => '']);
    }

    public static function dataStrStr($data)
    {
        if (is_array($data)) {
            $newData = [];
            foreach ($data as $k => $v) {
                $k = strtolower(self::strstr($k));
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        $k2 = strtolower(self::strstr($k2));
                        $newData[$k][$k2] = $v2;
                    }
                }
            }

            return $newData;
        }

        return $data;
    }

    /**
     * 针对1个页面中只有一个table表格
     *
     * @param $url
     *
     * @return array
     */
    public static function table($url)
    {
        $qlg = QueryList::get($url);
        $html = $qlg->find('article')->html();
        $ql = QueryList::html($html);
        $result = [];
        $ql->find("table")->map(function (Elements $element) use (&$result) {
            $header = $element->find('thead th')->texts()->all();
            $row = $element->find('tbody tr')->map(function ($row) {
                return $row->find('td')->texts()->all();
            })->all();
            $result = compact('header', 'row');
        });

        return $result;
    }

    /**
     * 针对1个页面中只有多个table表格
     *
     * @param $url
     *
     * @return array
     */
    public static function tables($url)
    {
        $qlg = QueryList::get($url);
        $html = $qlg->find('article')->html();
        $ql = QueryList::html($html);
        $result = [];
        $ql->find('h2')->each(function ($h2) use (&$result) {
            $sectionTitle = $h2->text();
            $table = $h2->nextAll('table')->eq(0);
            if ($table->count() > 0) {
                $header = $table->find('thead th')->texts()->all();
                $row = $table->find('tbody tr')->map(function ($row) {
                    return $row->find('td')->texts()->all();
                })->all();
                $result[$sectionTitle] = compact('header', 'row');
            }
        });

        return self::dataStrStr($result);
    }
}

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

class File
{
    public static function readCSV($csvFileName)
    {
        if ( ! is_file($csvFileName)) {
            throw new \RuntimeException("File '{$csvFileName}' does not exist");
        }
        $handle = fopen($csvFileName, 'r');
        if ( ! $handle) {
            throw new \RuntimeException("Cannot open file '{$csvFileName}'");
        }
        $csvData = [];
        while (($data = fgetcsv($handle)) !== false) {
            // 下面这行代码可以解决中文字符乱码问题
            // $write[0] = iconv('gbk', 'utf-8', $write[0]);
            $csvData[] = $data;
        }

        return $csvData;
    }
}

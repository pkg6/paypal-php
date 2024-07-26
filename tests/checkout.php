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

require 'vendor/autoload.php';

//https://developer.paypal.com/studio/checkout/standard/integrate

$config = [
    'mode' => 'sandbox', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'client_id' => 'AevBF4PqFcmD0eCBWFK_x06-DP6XlF_o4Q5biHs4Fr2c1FpIa-xBvCo-OqcKdMSYzETwlxTSl4c1slTp',
    'client_secret' => 'EAovilZWM798SG51rfhIwjJQ04HirWlXHO7SFzzs0_t3mRd8Wt2u7yNGNCPTW2kJ2k39wt7HrQT919zO',
    'app_id' => 'APP-80W284485P519543T',
    'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
    'currency' => 'USD',
    'locale' => 'en_US',
    'notify_url' => 'https://local.domain.com',
    'validate_ssl' => true
];
$rest = new \pkg6\paypal\RestClient($config);
$rest->getAccessToken();

//创建预付订单
$order = $rest->createOrder([
    'intent' => 'CAPTURE',
    'purchase_units' => [
        [
            'amount' => ['currency_code' => 'USD', 'value' => '100.00'],
        ]
    ]
]);
//{"id":"66J83131TG7547040","status":"CREATED","links":[{"href":"https:\/\/api.sandbox.paypal.com\/v2\/checkout\/orders\/66J83131TG7547040","rel":"self","method":"GET"},{"href":"https:\/\/www.sandbox.paypal.com\/checkoutnow?token=66J83131TG7547040","rel":"approve","method":"GET"},{"href":"https:\/\/api.sandbox.paypal.com\/v2\/checkout\/orders\/66J83131TG7547040","rel":"update","method":"PATCH"},{"href":"https:\/\/api.sandbox.paypal.com\/v2\/checkout\/orders\/66J83131TG7547040\/capture","rel":"capture","method":"POST"}]}
// 您需要一个captureOrder将资金从付款人转移到商家的功能
$order = $rest->capturePaymentOrder($order['id']);


<?php

require 'vendor/autoload.php';

//https://developer.paypal.com/docs/api/payments/v2/#captures_refund

$config = [
    'mode' => 'sandbox', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'client_id' => '',
    'client_secret' => '',
    'app_id' => 'APP-80W284485P519543T',
    'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
    'currency' => 'USD',
    'locale' => 'en_US',
    'notify_url' => 'https://local.domain.com',
    'validate_ssl' => true
];
$rest = new \pkg6\paypal\RestClient($config);
$rest->getAccessToken();

$ret = $rest->setCurrency("USD")->refundCapturedPayment("5C509697X3520114A", date('y-m-d H:i:s'), 1, '退款');

var_dump($ret);
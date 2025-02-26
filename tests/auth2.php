<?php

require 'vendor/autoload.php';
//https://developer.paypal.com/docs/log-in-with-paypal/
//https://github.com/overtrue/socialite

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


if (!$_GET['code']) {
    $url = $rest->oAuth2GenerateURL("http://localhost.zhiqiang.wang");
    header("Location: " . $url);
    exit;
}
$user = $rest->oAuth2GetUserByCode($_GET['code']);
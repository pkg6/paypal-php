<?php
require 'vendor/autoload.php';

//https://developer.paypal.com/docs/api/payments.payouts-batch/v1/#payouts_post

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

$ret = $rest->createBatchPayout([
    'sender_batch_header' => [
        'sender_batch_id' => 'Payouts_2018_100007',
        'email_subject' => 'You have a payout!',
        'email_message' => 'You have received a payout! Thanks for using our service!',
    ],
    'items' => [
        [
            'recipient_type' => 'EMAIL',
            'amount' => [
                'currency' => 'USD',
                'value' => '10.00',
            ],
            'note' => 'Thanks for your patronage!',
            'sender_item_id' => '201403140001',
            'receiver' => 'sb-lqni931374048@business.example.com',
            'alternate_notification_method' => [
                'phone' => [
                    'country_code' => '91',
                    'national_number' => '9999988888'
                ]
            ],
            'notification_language' => 'fr-FR',
            "purpose" => "GOODS"
        ]
    ]
]);

var_dump($ret);

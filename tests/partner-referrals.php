<?php
require 'vendor/autoload.php';

//https://developer.paypal.com/docs/multiparty/seller-onboarding/before-payment/
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

//创建预付订单
$partnerReferral = $rest->createPartnerReferral([
    'tracking_id' => '1',
    'operations' => [
        [
            'operation' => "API_INTEGRATION",
            'api_integration_preference' => [
                'rest_api_integration' => [
                    'integration_method' => 'PAYPAL',
                    'integration_type' => 'THIRD_PARTY',
                    'third_party_details' => [
                        'features' => [
                            'PAYMENT',
                            'REFUND'
                        ]
                    ]
                ]
            ]
        ]
    ],
    "products" => [
        'EXPRESS_CHECKOUT'
    ],
    'legal_consents' => [
        [
            'type' => 'SHARE_DATA_CONSENT',
            'granted' => true,
        ]
    ]
]);


//{
//    "links": [
//        {
//            "href": "https:\/\/api.sandbox.paypal.com\/v2\/customer\/partner-referrals\/ZGZhZTE4MzctYjg0Mi00NjI3LTk0MjUtNGVjZmE4MzBlNjI2K2ZhNDRvNjhSeUhHeloydEpjYjNPVnU3Y2luUjhqUmUySlUrellVSDZVbz12Mg==",
//            "rel": "self",
//            "method": "GET",
//            "description": "Read Referral Data shared by the Caller."
//        },
//        {
//            "href": "https:\/\/www.sandbox.paypal.com\/bizsignup\/partner\/entry?referralToken=ZGZhZTE4MzctYjg0Mi00NjI3LTk0MjUtNGVjZmE4MzBlNjI2K2ZhNDRvNjhSeUhHeloydEpjYjNPVnU3Y2luUjhqUmUySlUrellVSDZVbz12Mg==",
//            "rel": "action_url",
//            "method": "GET",
//            "description": "Target WEB REDIRECT URL for the next action. Customer should be redirected to this URL in the browser."
//        }
//    ]
//}
echo json_encode($partnerReferral);

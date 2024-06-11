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

namespace pkg6\paypal\rest;

use Symfony\Component\HttpFoundation\Request;

trait PayPalVerifyIPN
{
    /**
     * @var string
     */
    protected $webhookID;

    /**
     * @param string $webhookID
     *
     * @return $this
     */
    public function setWebHookID(string $webhookID)
    {
        $this->webhookID = $webhookID;

        return $this;
    }

    /**
     * Verify incoming IPN through a web hook id.
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     */
    public function verifyIPN(Request $request)
    {
        $headers = array_change_key_case($request->headers->all(), CASE_UPPER);

        if ( ! isset($headers['PAYPAL-AUTH-ALGO'][0]) ||
            ! isset($headers['PAYPAL-TRANSMISSION-ID'][0]) ||
            ! isset($headers['PAYPAL-CERT-URL'][0]) ||
            ! isset($headers['PAYPAL-TRANSMISSION-SIG'][0]) ||
            ! isset($headers['PAYPAL-TRANSMISSION-TIME'][0]) ||
            ! isset($this->webhookID)
        ) {
            $this->logger->error('Invalid headers or webhook id supplied for paypal webhook');

            return ['error' => 'Invalid headers or webhook id provided'];
        }
        $params = json_decode($request->getContent());
        $payload = [
            'auth_algo' => $headers['PAYPAL-AUTH-ALGO'][0],
            'cert_url' => $headers['PAYPAL-CERT-URL'][0],
            'transmission_id' => $headers['PAYPAL-TRANSMISSION-ID'][0],
            'transmission_sig' => $headers['PAYPAL-TRANSMISSION-SIG'][0],
            'transmission_time' => $headers['PAYPAL-TRANSMISSION-TIME'][0],
            'webhook_id' => $this->webhookID,
            'webhook_event' => $params,
        ];

        return $this->verifyWebHook($payload);
    }
}

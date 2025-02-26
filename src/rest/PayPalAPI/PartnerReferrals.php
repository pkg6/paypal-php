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

namespace pkg6\paypal\rest\PayPalAPI;

trait PartnerReferrals
{

    public function setPartnerHeader($clientId, $payerId)
    {
        //https://developer.paypal.com/api/rest/requests/#paypal-partner-attribution-id.
        $assertionFn = function ($clientId, $payerId) {
            $base64UrlEncode = function ($input) {
                return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($input));
            };
            // JWT Header
            $header = json_encode(['alg' => 'none']);
            $encodedHeader = $base64UrlEncode($header);
            // JWT Payload
            $payload = json_encode([
                'iss' => $clientId,
                'payer_id' => $payerId,
            ]);
            $encodedPayload = $base64UrlEncode($payload);
            // Signature (empty for unsigned JWT)
            $signature = '';
            // Concatenate the parts with periods
            return "{$encodedHeader}.{$encodedPayload}.{$signature}";
        };
        $this->setRequestHeader("PayPal-Partner-Attribution-Id", "");
        $this->setRequestHeader("PayPal-Auth-Assertion", $assertionFn($clientId, $payerId));
    }

    /**
     * Create a Partner Referral.
     *
     * @param array $partner_data
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/partner-referrals/v2/#partner-referrals_create
     */
    public function createPartnerReferral(array $partner_data)
    {
        $this->apiEndPoint = 'v2/customer/partner-referrals';

        $this->options['json'] = $partner_data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * Get Partner Referral Details.
     *
     * @param string $partner_referral_id
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/partner-referrals/v2/#partner-referrals_read
     */
    public function showReferralData(string $partner_referral_id)
    {
        $this->apiEndPoint = "v2/customer/partner-referrals/{$partner_referral_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * List Seller Tracking Information.
     *
     * @param string $partner_id
     * @param string $tracking_id
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/partner-referrals/v1/#merchant-integration_find
     */
    public function listSellerTrackingInformation(string $partner_id, string $tracking_id)
    {
        $this->apiEndPoint = "v1/customer/partners/{$partner_id}/merchant-integrations?tracking_id={$tracking_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Show Seller Status.
     *
     * @param string $partner_id
     * @param string $merchant_id
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/partner-referrals/v1/#merchant-integration_status
     */
    public function showSellerStatus(string $partner_id, string $merchant_id)
    {
        $this->apiEndPoint = "v1/customer/partners/{$partner_id}/merchant-integrations/{$merchant_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * List Merchant Credentials.
     *
     * @param string $partner_id
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/partner-referrals/v1/#merchant-integration_credentials
     */
    public function listMerchantCredentials(string $partner_id)
    {
        $this->apiEndPoint = "v1/customer/partners/{$partner_id}/merchant-integrations/credentials";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }
}

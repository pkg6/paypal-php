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

trait PayPalExperienceContext
{
    /**
     * @var array
     */
    protected $experienceContext = [];

    /**
     * Set Brand Name when setting experience context for payment.
     *
     * @param string $brand
     *
     * @return $this
     */
    public function setBrandName(string $brand)
    {
        $this->experienceContext = array_merge($this->experienceContext, [
            'brand_name' => $brand,
        ]);

        return $this;
    }

    /**
     * Set return & cancel urls.
     *
     * @param string $return_url
     * @param string $cancel_url
     *
     * @return $this
     */
    public function setReturnAndCancelUrl(string $return_url, string $cancel_url)
    {
        $this->experienceContext = array_merge($this->experienceContext, [
            'return_url' => $return_url,
            'cancel_url' => $cancel_url,
        ]);

        return $this;
    }

    /**
     * Set stored payment source.
     *
     * @param string      $initiator
     * @param string      $type
     * @param string      $usage
     * @param bool        $previous_reference
     * @param string|null $previous_transaction_id
     * @param string|null $previous_transaction_date
     * @param string|null $previous_transaction_reference_number
     * @param string|null $previous_transaction_network
     *
     * @return $this
     */
    public function setStoredPaymentSource(string $initiator, string $type, string $usage, bool $previous_reference = false, string $previous_transaction_id = null, string $previous_transaction_date = null, string $previous_transaction_reference_number = null, string $previous_transaction_network = null): \Srmklive\PayPal\Services\PayPal
    {
        $this->experienceContext = array_merge($this->experienceContext, [
            'stored_payment_source' => [
                'payment_initiator' => $initiator,
                'payment_type' => $type,
                'usage' => $usage,
            ],
        ]);

        if ($previous_reference === true) {
            $this->experienceContext['stored_payment_source']['previous_network_transaction_reference'] = [
                'id' => $previous_transaction_id,
                'date' => $previous_transaction_date,
                'acquirer_reference_number' => $previous_transaction_reference_number,
                'network' => $previous_transaction_network,
            ];
        }

        return $this;
    }
}

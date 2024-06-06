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

namespace pkg6\paypal\rest\PayPalAPI\PaymentMethodsTokens;

trait Helpers
{
    /**
     * @var array
     */
    protected $payment_source = [];

    /**
     * @var array
     */
    protected $customer_source = [];

    /**
     * Set payment method token by token id.
     *
     * @param string $id
     * @param string $type
     *
     * @return $this
     */
    public function setTokenSource(string $id, string $type)
    {
        $token_source = [
            'id' => $id,
            'type' => $type,
        ];

        return $this->setPaymentSourceDetails('token', $token_source);
    }

    /**
     * Set payment method token customer id.
     *
     * @param string $id
     *
     * @return $this
     */
    public function setCustomerSource(string $id)
    {
        $this->customer_source = [
            'id' => $id,
        ];

        return $this;
    }

    /**
     * Set payment source data for credit card.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setPaymentSourceCard(array $data)
    {
        return $this->setPaymentSourceDetails('card', $data);
    }

    /**
     * Set payment source data for PayPal.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setPaymentSourcePayPal(array $data)
    {
        return $this->setPaymentSourceDetails('paypal', $data);
    }

    /**
     * Set payment source data for Venmo.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setPaymentSourceVenmo(array $data)
    {
        return $this->setPaymentSourceDetails('venmo', $data);
    }

    /**
     * Set payment source details.
     *
     * @param string $source
     * @param array  $data
     *
     * @return $this
     */
    protected function setPaymentSourceDetails(string $source, array $data)
    {
        $this->payment_source[$source] = $data;

        return $this;
    }

    /**
     * Send request for creating payment method token/source.
     *
     * @param bool $create_source
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     */
    public function sendPaymentMethodRequest(bool $create_source = false)
    {
        $token_payload = ['payment_source' => $this->payment_source];

        if ( ! empty($this->customer_source)) {
            $token_payload['customer'] = $this->customer_source;
        }

        return ($create_source === true) ? $this->createPaymentSetupToken(array_filter($token_payload)) : $this->createPaymentSourceToken(array_filter($token_payload));
    }
}

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

namespace pkg6\paypal\rest\PayPalAPI\Orders;

use Throwable;

trait Helpers
{
    /**
     * Confirm payment for an order.
     *
     * @param string $order_id
     * @param string $processing_instruction
     *
     * @throws Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     */
    public function setupOrderConfirmation(string $order_id, string $processing_instruction = '')
    {
        $body = [
            'processing_instruction' => $processing_instruction,
            'application_context' => $this->experienceContext,
            'payment_source' => $this->payment_source,
        ];

        return $this->confirmOrder($order_id, $body);
    }
}

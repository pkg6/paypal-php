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

trait WebHooksVerification
{
    /**
     * Verify a web hook from PayPal.
     *
     * @param array $data
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/webhooks/v1/#verify-webhook-signature_post
     */
    public function verifyWebHook(array $data)
    {
        $this->apiEndPoint = 'v1/notifications/verify-webhook-signature';

        $this->options['json'] = $data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }
}

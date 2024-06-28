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

/**
 * @see  https://developer.paypal.com/docs/log-in-with-paypal/integrate/
 */
trait OAuth2
{

    /**
     * @param $redirectUrl
     * @param $mergeField
     *
     * @return string
     *
     * @see https://developer.paypal.com/docs/log-in-with-paypal/integrate/generate-button/
     *
     * get user info
     * @see getAccessToken(['code'=>$code])
     * @see showProfileInfo()
     *  or
     * @see OAuth2GetUserByCode
     * @ getUserInfo
     */
    public function oAuth2GenerateURL($redirectUrl, $mergeField = [])
    {
        $query = array_merge(
            [
                'flowEntry' => 'static',
                'client_id' => $this->config['client_id'],
                'response_type' => 'code',
                'scope' => \implode(' ', [
                    'openid', 'profile', 'email', 'address',
                ]),
                'redirect_uri' => $redirectUrl,
            ],
            $mergeField
        );

        return $this->config['gateway_url']
            . "/signin/authorize?"
            . http_build_query($query, '', '&', PHP_QUERY_RFC1738);
    }

    /**
     * @param $code
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     */
    public function oAuth2GetUserByCode($code)
    {
        $this->getAccessToken(['code' => $code]);

        return $this->showProfileInfo();
    }
}

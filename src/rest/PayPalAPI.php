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

use GuzzleHttp\Utils;

trait PayPalAPI
{
    use PayPalAPI\Trackers;
    use PayPalAPI\CatalogProducts;
    use PayPalAPI\Disputes;
    use PayPalAPI\DisputesActions;
    use PayPalAPI\Identity;
    use PayPalAPI\Invoices;
    use PayPalAPI\InvoicesSearch;
    use PayPalAPI\InvoicesTemplates;
    use PayPalAPI\Orders;
    use PayPalAPI\PartnerReferrals;
    use PayPalAPI\PaymentExperienceWebProfiles;
    use PayPalAPI\PaymentMethodsTokens;
    use PayPalAPI\PaymentAuthorizations;
    use PayPalAPI\PaymentCaptures;
    use PayPalAPI\PaymentRefunds;
    use PayPalAPI\Payouts;
    use PayPalAPI\ReferencedPayouts;
    use PayPalAPI\BillingPlans;
    use PayPalAPI\Subscriptions;
    use PayPalAPI\Reporting;
    use PayPalAPI\WebHooks;
    use PayPalAPI\WebHooksVerification;
    use PayPalAPI\WebHooksEvents;

    use PayPalAPI\OAuth2;

    /**
     * PayPal access token.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * @return array|bool|float|int|object|\Psr\Http\Message\StreamInterface|string|null
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function getAccessTokenWithCache()
    {
        if (is_null($this->cache)) {
            return $this->getAccessToken();
        }
        $cacheKey = $this->config['client_id'] . '-' . $this->config['client_secret'] . '-' . md5(json_encode($this->config));
        $response = [];
        if ($this->cache->has($cacheKey)) {
            $cacheValue = $this->cache->get($cacheKey);
            if ( ! empty($cacheValue)) {
                $response = Utils::jsonDecode($cacheValue, true);
            }
        }
        if (empty($response)) {
            $response = $this->getAccessToken();
            $this->cache->set($cacheKey, Utils::jsonEncode($response), $response['expires_in'] ?? 0);
        }
        $this->setAccessToken($response);

        return $response;
    }

    /**
     * Login through PayPal API to get access token.
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/get-an-access-token-curl/
     * @see https://developer.paypal.com/docs/api/get-an-access-token-postman/
     */
    public function getAccessToken($form_params = [])
    {
        $this->apiEndPoint = 'v1/oauth2/token';

        $this->options['auth'] = [$this->config['client_id'], $this->config['client_secret']];
        $this->options[$this->httpBodyParam] = array_merge([
            'grant_type' => 'client_credentials',
        ], $form_params);
        $response = $this->doPayPalRequest();
        unset($this->options['auth']);
        unset($this->options[$this->httpBodyParam]);

        if (isset($response['access_token'])) {
            $this->setAccessToken($response);
        }

        return $response;
    }

    /**
     * Set PayPal Rest API access token.
     *
     * @param array $response
     *
     * @return void
     */
    public function setAccessToken(array $response)
    {
        $this->accessToken = $response['access_token'];

        $this->setPayPalAppId($response);

        $this->setRequestHeader('Authorization', "{$response['token_type']} {$this->accessToken}");
    }

    /**
     * Set PayPal App ID.
     *
     * @param array $response
     *
     * @return void
     */
    private function setPayPalAppId(array $response)
    {
        $app_id = empty($response['app_id']) ? $this->config['app_id'] : $response['app_id'];

        $this->config['app_id'] = $app_id;
    }

    /**
     * Set records per page for list resources API calls.
     *
     * @param int $size
     *
     * @return $this
     */
    public function setPageSize(int $size)
    {
        $this->pageSize = $size;

        return $this;
    }

    /**
     * Set the current page for list resources API calls.
     *
     * @param int $size
     *
     * @return $this
     */
    public function setCurrentPage(int $page)
    {
        $this->currentPage = $page;

        return $this;
    }

    /**
     * Toggle whether totals for list resources are returned after every API call.
     *
     * @param bool $totals
     *
     * @return $this
     */
    public function showTotals(bool $totals)
    {
        $this->showTotals = var_export($totals, true);

        return $this;
    }
}

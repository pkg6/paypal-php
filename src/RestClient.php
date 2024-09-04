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

namespace pkg6\paypal;

use pkg6\paypal\contracts\Logger;
use pkg6\paypal\rest\PayPalAPI;
use pkg6\paypal\rest\PayPalExperienceContext;
use pkg6\paypal\rest\PayPalHttpClient;
use pkg6\paypal\rest\PayPalVerifyIPN;
use Psr\SimpleCache\CacheInterface;
use RuntimeException;

class RestClient
{
    use PayPalHttpClient;
    use PayPalAPI;
    use PayPalExperienceContext;
    use PayPalVerifyIPN;

    /**
     * @var array
     */
    protected $config;
    /**
     * @var CacheInterface
     */
    protected $cache = null;

    /**
     * @var Logger
     */
    protected $logger = null;
    /**
     * @var string
     */
    protected $mode;
    /**
     * @var int|string
     */
    protected $currency;
    /**
     * Set limit to total records per API call.
     *
     * @var int
     */
    protected $pageSize = 20;
    /**
     * Set the current page for list resources API calls.
     *
     * @var bool
     */
    protected $currentPage = 1;
    /**
     * Toggle whether totals for list resources are returned after every API call.
     *
     * @var bool
     */
    protected $showTotals = true;

    /**
     * @param array $config
     * @param CacheInterface|null $cache
     */
    public function __construct(
        array          $config,
        Logger $logger = null,
        CacheInterface $cache = null
    ) {
        $this->setApiCredentials($config);
        $this->setRequestHeader('Accept', 'application/json');
        if ( ! is_null($cache)) {
            $this->setCache($cache);
        }
        if ( ! is_null($logger)) {
            $this->setLogger($logger);
        }
    }

    /**
     * @param Logger|null $logger
     *
     * @return $this
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param CacheInterface $cache
     *
     * @return $this
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @param array $credentials
     *
     * @return $this
     */
    public function setApiCredentials(array $credentials)
    {
        // Setting Default PayPal Mode If not set
        $this->setApiEnvironment($credentials);
        // Set default currency.
        $this->setCurrency($credentials['currency']);
        // Set API configuration for the PayPal provider
        $this->setApiProviderConfiguration($credentials);
        // Set Http Client configuration.
        $this->setHttpClientConfiguration();

        return $this;
    }

    /**
     * Function to set currency.
     *
     * @param string $currency
     *
     * @return $this
     *
     * @throws \RuntimeException
     */
    public function setCurrency(string $currency = 'USD')
    {
        // Check if provided currency is valid.
        if ( ! in_array($currency, CurrencyCode::codes(), true)) {
            throw new RuntimeException('Currency is not supported by PayPal.');
        }
        $this->currency = $currency;

        return $this;
    }

    /**
     * Return the set currency.
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param array $credentials
     *
     * @return void
     */
    protected function setApiEnvironment(array $credentials)
    {
        $this->mode = 'live';
        if ( ! empty($mode = $credentials['mode'])) {
            $this->mode = ! in_array($mode, ['sandbox', 'live']) ? 'live' : $mode;
        } else {
            throw new RuntimeException('Invalid configuration provided. Please provide valid configuration for PayPal API. You can also refer to the documentation at https://github.com/pkg6/paypal-php/wiki/PayPal-REST-APIs to setup correct configuration.');
        }
    }

    /**
     * @param array $credentials
     *
     * @return void
     */
    protected function setApiProviderConfiguration(array $credentials)
    {
        $config_params = ['client_id', 'client_secret'];
        foreach ($config_params as $item) {
            if (empty($credentials[$item])) {
                throw new RuntimeException("{$item} missing from the provided configuration. Please add your application {$item}.");
            } else {
                $this->config[$item] = $credentials[$item];
            }
        }
        if (isset($credentials['app_id'])) {
            $this->config['app_id'] = $credentials['app_id'];
        }
        $this->paymentAction = $credentials['payment_action'];
        $this->locale = $credentials['locale'];
        $this->setRequestHeader('Accept-Language', $this->locale);
        $this->validateSSL = $credentials['validate_ssl'];
        $this->setOptions($credentials);
    }

    public function setLiveURL()
    {
        $this->config['api_url'] = 'https://api-m.paypal.com';
        $this->config['gateway_url'] = 'https://www.paypal.com';
        $this->config['ipn_url'] = 'https://ipnpb.paypal.com/cgi-bin/webscr';
    }

    public function setSandboxURL()
    {
        $this->config['api_url'] = 'https://api-m.sandbox.paypal.com';
        $this->config['gateway_url'] = 'https://www.sandbox.paypal.com';
        $this->config['ipn_url'] = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
    }

    /**
     * @param array $credentials
     *
     * @return void
     */
    protected function setOptions($credentials)
    {
        // Setting API Endpoints
        $this->setLiveURL();
        if ($this->mode === 'sandbox') {
            $this->setSandboxURL();
        }
        // Adding params outside sandbox / live array
        $this->config['payment_action'] = $credentials['payment_action'];
        $this->config['notify_url'] = $credentials['notify_url'];
        $this->config['locale'] = $credentials['locale'];
    }

}

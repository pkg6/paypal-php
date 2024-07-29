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

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException as HttpClientException;
use GuzzleHttp\Utils;
use pkg6\paypal\LocaleCode;
use pkg6\paypal\support\Str;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

trait PayPalHttpClient
{
    /**
     * Http Client class object.
     *
     * @var HttpClient
     */
    private $client;

    /**
     * Http Client configuration.
     *
     * @var array
     */
    private $httpClientConfig;

    /**
     * PayPal API Endpoint.
     *
     * @var string
     */
    private $apiUrl;

    /**
     * PayPal API Endpoint.
     *
     * @var string
     */
    private $apiEndPoint;

    /**
     * IPN notification url for PayPal.
     *
     * @var string
     */
    private $notifyUrl;

    /**
     * Http Client request body parameter name.
     *
     * @var string
     */
    private $httpBodyParam = 'form_params';

    /**
     * Default payment action for PayPal.
     *
     * @var string
     */
    private $paymentAction;

    /**
     * Default locale for PayPal.
     *
     * @var string
     */
    private $locale;

    /**
     * Validate SSL details when creating HTTP client.
     *
     * @var bool
     */
    private $validateSSL;

    /**
     * Request type.
     *
     * @var string
     */
    protected $verb = 'post';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * Set curl constants if not defined.
     *
     * @return void
     */
    protected function setCurlConstants()
    {
        $constants = [
            'CURLOPT_SSLVERSION' => 32,
            'CURL_SSLVERSION_TLSv1_2' => 6,
            'CURLOPT_SSL_VERIFYPEER' => 64,
            'CURLOPT_SSLCERT' => 10025,
        ];

        foreach ($constants as $key => $item) {
            $this->defineCurlConstant($key, $item);
        }
    }

    /**
     * Declare a curl constant.
     *
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    protected function defineCurlConstant(string $key, string $value)
    {
        return defined($key) ? true : define($key, $value);
    }

    /**
     * Function to initialize/override Http Client.
     *
     * @param \GuzzleHttp\Client|null $client
     *
     * @return void
     */
    public function setClient(HttpClient $client = null)
    {
        if ($client instanceof HttpClient) {
            $this->client = $client;

            return;
        }

        $this->client = new HttpClient([
            'curl' => $this->httpClientConfig,
        ]);
    }

    /**
     * Function to set Http Client configuration.
     *
     * @return void
     */
    protected function setHttpClientConfiguration()
    {
        $this->setCurlConstants();
        $this->httpClientConfig = [
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_SSL_VERIFYPEER => $this->validateSSL,
        ];
        // Initialize Http Client
        $this->setClient();
        // Set default values.
        $this->setDefaultValues();
        // Set PayPal IPN Notification URL
        $this->notifyUrl = $this->config['notify_url'];
    }

    /**
     * Set default values for configuration.
     *
     * @return void
     */
    private function setDefaultValues()
    {
        $paymentAction = empty($this->paymentAction) ? 'Sale' : $this->paymentAction;
        $this->paymentAction = $paymentAction;

        $locale = empty($this->locale) ? LocaleCode::EN_US : $this->locale;
        $this->locale = $locale;

        $validateSSL = empty($this->validateSSL) ? true : $this->validateSSL;
        $this->validateSSL = $validateSSL;

        $this->showTotals = var_export($this->showTotals, true);
    }

    /**
     * Perform PayPal API request & return response.
     *
     * @return StreamInterface
     *
     * @throws \Throwable
     */
    private function makeHttpRequest(): StreamInterface
    {
        try {
            return $this->client->{$this->verb}(
                $this->apiUrl,
                $this->options
            )->getBody();
        } catch (HttpClientException $e) {
            throw new RuntimeException($e->getResponse()->getBody());
        }
    }

    /**
     * Function To Perform PayPal API Request.
     *
     * @param bool $decode
     *
     * @return array|bool|float|int|object|string|null
     *
     * @throws \Throwable
     */
    private function doPayPalRequest(bool $decode = true)
    {
        try {
            $this->apiUrl = $this->config['api_url'] . '/' . $this->apiEndPoint;
            // Perform PayPal HTTP API request.
            $response = $this->makeHttpRequest();

            return ($decode === false) ? $response->getContents() : Utils::jsonDecode($response, true);
        } catch (RuntimeException $t) {
            $error = ($decode === false) || (Str::isJson($t->getMessage()) === false) ? $t->getMessage() : Utils::jsonDecode($t->getMessage(), true);

            return ['error' => $error];
        }
    }

    /**
     * Function to add request header.
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setRequestHeader(string $key, string $value)
    {
        $this->options['headers'][$key] = $value;

        return $this;
    }

    /**
     * Function to add multiple request headers.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setRequestHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            $this->setRequestHeader($key, $value);
        }

        return $this;
    }

    /**
     * Return request options header.
     *
     * @param string $key
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getRequestHeader(string $key): string
    {
        if (isset($this->options['headers'][$key])) {
            return $this->options['headers'][$key];
        }

        throw new RuntimeException('Options header is not set.');
    }
}

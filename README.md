# Installation

```
composer require pkg6/paypal
```

# Using the Documentation

- ## [RestClient](https://github.com/pkg6/paypal-php/wiki/PayPal-REST-APIs)

~~~
$config = [
    // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'mode'           => 'live',
    'client_id'      => 'some-client-id',
    'client_secret'  => 'some-client-secret',
    'app_id'         => 'APP-80W284485P519543T',
     // Can only be 'Sale', 'Authorization' or 'Order'
    'payment_action' => 'Sale',
    'currency'       => 'USD',
     // Change this accordingly for your application.
    'notify_url'     => 'https://your-app.com/paypal/notify',
    // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'locale'         => 'en_US',
    // Validate SSL when creating api client.
    'validate_ssl'   => true,
];
$rest = new \pkg6\paypal\RestClient($config);
//Get Access Token
$rest->getAccessToken();
~~~

> For more instructions, see the documentation:
>
> https://github.com/pkg6/paypal-php/wiki/PayPal-REST-APIs

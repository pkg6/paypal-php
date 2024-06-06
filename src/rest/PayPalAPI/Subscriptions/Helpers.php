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

namespace pkg6\paypal\rest\PayPalAPI\Subscriptions;

use Carbon\Carbon;
use pkg6\paypal\support\Str;
use Throwable;

trait Helpers
{
    /**
     * @var array
     */
    protected $trialPricing = [];

    /**
     * @var int
     */
    protected $paymentFailureThreshold = 3;

    /**
     * @var array
     */
    protected $product;

    /**
     * @var array
     */
    protected $billingPlan;

    /**
     * @var array
     */
    protected $shippingAddress;

    /**
     * @var array
     */
    protected $paymentPreferences;

    /**
     * @var bool
     */
    protected $hasSetupFee = false;

    /**
     * @var array
     */
    protected $taxes;

    /**
     * @var string
     */
    protected $customID;

    /**
     * Setup a subscription.
     *
     * @param string $customer_name
     * @param string $customer_email
     * @param string $start_date
     *
     * @throws Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     */
    public function setupSubscription(string $customer_name, string $customer_email, string $start_date = '')
    {
        $body = [
            'plan_id' => $this->billingPlan['id'],
            'quantity' => 1,
            'subscriber' => [
                'name' => [
                    'given_name' => $customer_name,
                ],
                'email_address' => $customer_email,
            ],
        ];

        if ( ! empty($start_date)) {
            $body['start_time'] = Carbon::parse($start_date)->toIso8601String();
        }

        if ($this->hasSetupFee) {
            $body['plan'] = [
                'payment_preferences' => $this->paymentPreferences,
            ];
        }

        if (isset($this->shippingAddress)) {
            $body['subscriber']['shipping_address'] = $this->shippingAddress;
        }

        if (isset($this->experienceContext)) {
            $body['application_context'] = $this->experienceContext;
        }

        if (isset($this->taxes)) {
            $body['taxes'] = $this->taxes;
        }

        if (isset($this->customID)) {
            $body['custom_id'] = $this->customID;
        }

        $subscription = $this->createSubscription($body);
        $subscription['billing_plan_id'] = $this->billingPlan['id'];
        $subscription['product_id'] = $this->product['id'];

        unset($this->product);
        unset($this->billingPlan);
        unset($this->trialPricing);
        unset($this->return_url);
        unset($this->cancel_url);

        return $subscription;
    }

    /**
     * Add a subscription trial pricing tier.
     *
     * @param string    $interval_type
     * @param int       $interval_count
     * @param float|int $price
     * @param int       $total_cycles
     *
     * @return $this
     */
    public function addPlanTrialPricing(string $interval_type, int $interval_count, float $price = 0, int $total_cycles = 1)
    {
        $this->trialPricing = $this->addPlanBillingCycle($interval_type, $interval_count, $price, $total_cycles, true);

        return $this;
    }

    /**
     * Create a recurring daily billing plan.
     *
     * @param string    $name
     * @param string    $description
     * @param float|int $price
     * @param int       $total_cycles
     *
     * @throws Throwable
     *
     * @return $this
     */
    public function addDailyPlan(string $name, string $description, float $price, int $total_cycles = 0)
    {
        if (isset($this->billingPlan)) {
            return $this;
        }

        $plan_pricing = $this->addPlanBillingCycle('DAY', 1, $price, $total_cycles);
        $billing_cycles = empty($this->trialPricing) ?
            [$plan_pricing]
            : array_filter([$this->trialPricing, $plan_pricing]);

        $this->addBillingPlan($name, $description, $billing_cycles);

        return $this;
    }

    /**
     * Create a recurring weekly billing plan.
     *
     * @param string    $name
     * @param string    $description
     * @param float|int $price
     * @param int       $total_cycles
     *
     * @throws Throwable
     *
     * @return $this
     */
    public function addWeeklyPlan(string $name, string $description, float $price, int $total_cycles = 0)
    {
        if (isset($this->billingPlan)) {
            return $this;
        }

        $plan_pricing = $this->addPlanBillingCycle('WEEK', 1, $price, $total_cycles);
        $billing_cycles = empty($this->trialPricing)
            ? [$plan_pricing]
            : array_filter([$this->trialPricing, $plan_pricing]);

        $this->addBillingPlan($name, $description, $billing_cycles);

        return $this;
    }

    /**
     * Create a recurring monthly billing plan.
     *
     * @param string    $name
     * @param string    $description
     * @param float|int $price
     * @param int       $total_cycles
     *
     * @throws Throwable
     *
     * @return $this
     */
    public function addMonthlyPlan(string $name, string $description, float $price, int $total_cycles = 0)
    {
        if (isset($this->billingPlan)) {
            return $this;
        }

        $plan_pricing = $this->addPlanBillingCycle('MONTH', 1, $price, $total_cycles);
        $billing_cycles = empty($this->trialPricing)
            ? [$plan_pricing]
            : array_filter([$this->trialPricing, $plan_pricing]);

        $this->addBillingPlan($name, $description, $billing_cycles);

        return $this;
    }

    /**
     * Create a recurring annual billing plan.
     *
     * @param string    $name
     * @param string    $description
     * @param float|int $price
     * @param int       $total_cycles
     *
     * @throws Throwable
     *
     * @return $this
     */
    public function addAnnualPlan(string $name, string $description, float $price, int $total_cycles = 0)
    {
        if (isset($this->billingPlan)) {
            return $this;
        }

        $plan_pricing = $this->addPlanBillingCycle('YEAR', 1, $price, $total_cycles);
        $billing_cycles = empty($this->trialPricing)
            ? [$plan_pricing]
            : array_filter([$this->trialPricing, $plan_pricing]);

        $this->addBillingPlan($name, $description, $billing_cycles);

        return $this;
    }

    /**
     * Create a recurring billing plan with custom intervals.
     *
     * @param string    $name
     * @param string    $description
     * @param float|int $price
     * @param string    $interval_unit
     * @param int       $interval_count
     * @param int       $total_cycles
     *
     * @throws Throwable
     *
     * @return $this
     */
    public function addCustomPlan(string $name, string $description, float $price, string $interval_unit, int $interval_count, int $total_cycles = 0)
    {
        $billing_intervals = ['DAY', 'WEEK', 'MONTH', 'YEAR'];

        if (isset($this->billingPlan)) {
            return $this;
        }

        if ( ! in_array($interval_unit, $billing_intervals)) {
            throw new \RuntimeException('Billing intervals should either be ' . implode(', ', $billing_intervals));
        }

        $plan_pricing = $this->addPlanBillingCycle($interval_unit, $interval_count, $price, $total_cycles);
        $billing_cycles = empty($this->trialPricing)
            ? [$plan_pricing]
            : array_filter([$this->trialPricing, $plan_pricing]);

        $this->addBillingPlan($name, $description, $billing_cycles);

        return $this;
    }

    /**
     * Add Plan's Billing cycle.
     *
     * @param string $interval_unit
     * @param int    $interval_count
     * @param float  $price
     * @param int    $total_cycles
     * @param bool   $trial
     *
     * @return array
     */
    protected function addPlanBillingCycle(string $interval_unit, int $interval_count, float $price, int $total_cycles, bool $trial = false): array
    {
        $pricing_scheme = [
            'fixed_price' => [
                'value' => bcdiv($price, 1, 2),
                'currency_code' => $this->getCurrency(),
            ],
        ];

        if (empty($this->trialPricing)) {
            $plan_sequence = 1;
        } else {
            $plan_sequence = 2;
        }

        return [
            'frequency' => [
                'interval_unit' => $interval_unit,
                'interval_count' => $interval_count,
            ],
            'tenure_type' => ($trial === true) ? 'TRIAL' : 'REGULAR',
            'sequence' => ($trial === true) ? 1 : $plan_sequence,
            'total_cycles' => $total_cycles,
            'pricing_scheme' => $pricing_scheme,
        ];
    }

    /**
     * Create a product for a subscription's billing plan.
     *
     * @param string $name
     * @param string $description
     * @param string $type
     * @param string $category
     *
     * @throws Throwable
     *
     * @return $this
     */
    public function addProduct(string $name, string $description, string $type, string $category)
    {
        if (isset($this->product)) {
            return $this;
        }

        $request_id = Str::random();

        $product = $this->createProduct([
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'category' => $category,
        ], $request_id);

        if ($error = data_get($product, 'error', false)) {
            throw new \RuntimeException(data_get($error, 'details.0.description', 'Failed to add product'));
        }
        $this->product = $product;

        return $this;
    }

    /**
     * Add subscription's billing plan's product by ID.
     *
     * @param string $product_id
     *
     * @return $this
     */
    public function addProductById(string $product_id)
    {
        $this->product = [
            'id' => $product_id,
        ];

        return $this;
    }

    /**
     * Add subscription's billing plan by ID.
     *
     * @param string $plan_id
     *
     * @return $this
     */
    public function addBillingPlanById(string $plan_id)
    {
        $this->billingPlan = [
            'id' => $plan_id,
        ];

        return $this;
    }

    /**
     * Create a product for a subscription's billing plan.
     *
     * @param string $name
     * @param string $description
     * @param array  $billing_cycles
     *
     * @throws Throwable
     *
     * @return void
     */
    protected function addBillingPlan(string $name, string $description, array $billing_cycles): void
    {
        $request_id = Str::random();

        $plan_params = [
            'product_id' => $this->product['id'],
            'name' => $name,
            'description' => $description,
            'status' => 'ACTIVE',
            'billing_cycles' => $billing_cycles,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => $this->paymentFailureThreshold,
            ],
        ];

        $billingPlan = $this->createPlan($plan_params, $request_id);
        if ($error = data_get($billingPlan, 'error', false)) {
            throw new \RuntimeException(data_get($error, 'details.0.description', 'Failed to add billing plan'));
        }
        $this->billingPlan = $billingPlan;
    }

    /**
     * Set custom failure threshold when adding a subscription.
     *
     * @param int $threshold
     *
     * @return $this
     */
    public function addPaymentFailureThreshold(int $threshold)
    {
        $this->paymentFailureThreshold = $threshold;

        return $this;
    }

    /**
     * Add setup fee when adding a subscription.
     *
     * @param float $price
     *
     * @return $this
     */
    public function addSetupFee(float $price)
    {
        $this->hasSetupFee        = true;
        $this->paymentPreferences = [
            'auto_bill_outstanding' => true,
            'setup_fee' => [
                'value' => bcdiv($price, 1, 2),
                'currency_code' => $this->getCurrency(),
            ],
            'setup_fee_failure_action' => 'CONTINUE',
            'payment_failure_threshold' => $this->paymentFailureThreshold,
        ];

        return $this;
    }

    /**
     * Add shipping address.
     *
     * @param string $full_name
     * @param string $address_line_1
     * @param string $address_line_2
     * @param string $admin_area_2
     * @param string $admin_area_1
     * @param string $postal_code
     * @param string $country_code
     *
     * @return $this
     */
    public function addShippingAddress(string $full_name, string $address_line_1, string $address_line_2, string $admin_area_2, string $admin_area_1, string $postal_code, string $country_code)
    {
        $this->shippingAddress = [
            'name' => [
                'full_name' => $full_name,
            ],
            'address' => [
                'address_line_1' => $address_line_1,
                'address_line_2' => $address_line_2,
                'admin_area_2' => $admin_area_2,
                'admin_area_1' => $admin_area_1,
                'postal_code' => $postal_code,
                'country_code' => $country_code,
            ],
        ];

        return $this;
    }

    /**
     * Add taxes when creating a subscription.
     *
     * @param float $percentage
     *
     * @return $this
     */
    public function addTaxes(float $percentage)
    {
        $this->taxes = [
            'percentage' => $percentage,
            'inclusive' => false,
        ];

        return $this;
    }

    /**
     * Add custom id.
     *
     * @param string $custom_id
     *
     * @return $this
     */
    public function addCustomId(string $custom_id)
    {
        $this->customID = $custom_id;

        return $this;
    }
}

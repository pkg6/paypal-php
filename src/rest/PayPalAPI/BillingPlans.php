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

trait BillingPlans
{
    use BillingPlans\PricingSchemes;

    /**
     * Create a new billing plan.
     *
     * @param array $data
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/subscriptions/v1/#plans_create
     */
    public function createPlan(array $data)
    {
        $this->apiEndPoint = 'v1/billing/plans';

        $this->options['json'] = $data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * List all billing plans.
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/subscriptions/v1/#plans_list
     */
    public function listPlans()
    {
        $this->apiEndPoint = "v1/billing/plans?page={$this->currentPage}&page_size={$this->pageSize}&total_required={$this->showTotals}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Update an existing billing plan.
     *
     * @param string $plan_id
     * @param array  $data
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/invoicing/v2/#invoices_update
     */
    public function updatePlan(string $plan_id, array $data)
    {
        $this->apiEndPoint = "v1/billing/plans/{$plan_id}";

        $this->options['json'] = $data;

        $this->verb = 'patch';

        return $this->doPayPalRequest(false);
    }

    /**
     * Show details for an existing billing plan.
     *
     * @param string $plan_id
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/subscriptions/v1/#plans_get
     */
    public function showPlanDetails(string $plan_id)
    {
        $this->apiEndPoint = "v1/billing/plans/{$plan_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Activate an existing billing plan.
     *
     * @param string $plan_id
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/subscriptions/v1/#plans_activate
     */
    public function activatePlan(string $plan_id)
    {
        $this->apiEndPoint = "v1/billing/plans/{$plan_id}/activate";

        $this->verb = 'post';

        return $this->doPayPalRequest(false);
    }

    /**
     * Deactivate an existing billing plan.
     *
     * @param string $plan_id
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/subscriptions/v1/#plans_deactivate
     */
    public function deactivatePlan(string $plan_id)
    {
        $this->apiEndPoint = "v1/billing/plans/{$plan_id}/deactivate";

        $this->verb = 'post';

        return $this->doPayPalRequest(false);
    }

    /**
     * Update pricing for an existing billing plan.
     *
     * @param string $plan_id
     * @param array  $pricing
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/subscriptions/v1/#plans_update-pricing-schemes
     */
    public function updatePlanPricing(string $plan_id, array $pricing)
    {
        $this->apiEndPoint = "v1/billing/plans/{$plan_id}/update-pricing-schemes";

        $this->options['json'] = [
            'pricing_schemes' => $pricing,
        ];

        $this->verb = 'post';

        return $this->doPayPalRequest(false);
    }
}

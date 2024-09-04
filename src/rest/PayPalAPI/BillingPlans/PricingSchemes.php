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

namespace pkg6\paypal\rest\PayPalAPI\BillingPlans;

use Throwable;

trait PricingSchemes
{
    protected $pricingSchemes = [];

    /**
     * Add pricing scheme for the billing plan.
     *
     * @param string $interval_unit
     * @param int    $interval_count
     * @param float  $price
     * @param bool   $trial
     *
     * @throws Throwable
     *
     * @return $this
     */
    public function addPricingScheme(string $interval_unit, int $interval_count, float $price, bool $trial = false)
    {
        $this->pricingSchemes[] = $this->addPlanBillingCycle($interval_unit, $interval_count, $price, $trial);

        return $this;
    }

    /**
     * Process pricing updates for an existing billing plan.
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     */
    public function processBillingPlanPricingUpdates()
    {
        return $this->updatePlanPricing($this->billingPlan['id'], $this->pricingSchemes);
    }
}

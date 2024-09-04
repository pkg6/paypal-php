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

use Carbon\Carbon;

trait Reporting
{
    /**
     * List all transactions.
     *
     * @param array $filters
     * @param string $fields
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/transaction-search/v1/#transactions_get
     */
    public function listTransactions(array $filters, string $fields = 'all')
    {

        $filters_list = http_build_query($filters);
        $this->apiEndPoint = "v1/reporting/transactions?{$filters_list}fields={$fields}&page={$this->currentPage}&page_size={$this->pageSize}";
        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * List available balance.
     *
     * @param string $date
     * @param string $balance_currency
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/transaction-search/v1/#balances_get
     */
    public function listBalances(string $date = '', string $balance_currency = '')
    {
        $date = empty($date) ? Carbon::now()->toIso8601String() : Carbon::parse($date)->toIso8601String();
        $currency = empty($balance_currency) ? $this->getCurrency() : $balance_currency;

        $this->apiEndPoint = "v1/reporting/balances?currency_code={$currency}&as_of_time={$date}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }
}

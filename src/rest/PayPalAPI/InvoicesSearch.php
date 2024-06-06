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

use pkg6\paypal\rest\PayPalAPI\InvoiceSearch\Filters;

trait InvoicesSearch
{
    use Filters;

    /**
     * Search and return existing invoices.
     *
     * @throws \Throwable
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/invoicing/v2/#invoices_list
     */
    public function searchInvoices()
    {
        if (count($this->invoiceSearchFilters) < 1) {
            $this->invoiceSearchFilters = [
                'currency_code' => $this->getCurrency(),
            ];
        }

        $this->apiEndPoint = "v2/invoicing/search-invoices?page={$this->currentPage}&page_size={$this->pageSize}&total_required={$this->showTotals}";

        $this->options['json'] = $this->invoiceSearchFilters;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }
}

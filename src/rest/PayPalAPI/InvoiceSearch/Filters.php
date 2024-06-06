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

namespace pkg6\paypal\rest\PayPalAPI\InvoiceSearch;

use Carbon\Carbon;

trait Filters
{
    /**
     * @var array
     */
    protected $invoiceSearchFilters = [];

    /**
     * @var array
     */
    protected $invoices_date_types = [
        'invoice_date',
        'due_date',
        'payment_date',
        'creation_date',
    ];

    /**
     * @var array
     */
    protected $invoices_status_types = [
        'DRAFT',
        'SENT',
        'SCHEDULED',
        'PAID',
        'MARKED_AS_PAID',
        'CANCELLED',
        'REFUNDED',
        'PARTIALLY_PAID',
        'PARTIALLY_REFUNDED',
        'MARKED_AS_REFUNDED',
        'UNPAID',
        'PAYMENT_PENDING',
    ];

    /**
     * @param string $email
     *
     * @return $this
     */
    public function addInvoiceFilterByRecipientEmail(string $email)
    {
        $this->invoiceSearchFilters['recipient_email'] = $email;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function addInvoiceFilterByRecipientFirstName(string $name)
    {
        $this->invoiceSearchFilters['recipient_first_name'] = $name;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function addInvoiceFilterByRecipientLastName(string $name)
    {
        $this->invoiceSearchFilters['recipient_last_name'] = $name;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function addInvoiceFilterByRecipientBusinessName(string $name)
    {
        $this->invoiceSearchFilters['recipient_business_name'] = $name;

        return $this;
    }

    /**
     * @param string $invoice_number
     *
     * @return $this
     */
    public function addInvoiceFilterByInvoiceNumber(string $invoice_number)
    {
        $this->invoiceSearchFilters['invoice_number'] = $invoice_number;

        return $this;
    }

    /**
     * @param array $status
     *
     * @throws \Exception
     *
     * @return $this
     *
     * @see https://developer.paypal.com/docs/api/invoicing/v2/#definition-invoice_status
     */
    public function addInvoiceFilterByInvoiceStatus(array $status)
    {
        $invalid_status = false;

        foreach ($status as $item) {
            if ( ! in_array($item, $this->invoices_status_types)) {
                $invalid_status = true;
            }
        }

        if ($invalid_status === true) {
            throw new \Exception('status should be always one of these: ' . implode(',', $this->invoices_date_types));
        }

        $this->invoiceSearchFilters['status'] = $status;

        return $this;
    }

    /**
     * @param string $reference
     * @param bool   $memo
     *
     * @return $this
     */
    public function addInvoiceFilterByReferenceorMemo(string $reference, bool $memo = false)
    {
        $field = ($memo === false) ? 'reference' : 'memo';

        $this->invoiceSearchFilters[$field] = $reference;

        return $this;
    }

    /**
     * @param string $currency_code
     *
     * @return $this
     */
    public function addInvoiceFilterByCurrencyCode(string $currency_code = '')
    {
        $currency = ! isset($currency_code) ? $this->getCurrency() : $currency_code;

        $this->invoiceSearchFilters['currency_code'] = $currency;

        return $this;
    }

    /**
     * @param float  $start_amount
     * @param float  $end_amount
     * @param string $amount_currency
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function addInvoiceFilterByAmountRange(float $start_amount, float $end_amount, string $amount_currency = '')
    {
        if ($start_amount > $end_amount) {
            throw new \Exception('Starting amount should always be less than end amount!');
        }

        $currency = ! isset($amount_currency) ? $this->getCurrency() : $amount_currency;

        $this->invoiceSearchFilters['total_amount_range'] = [
            'lower_amount' => [
                'currency_code' => $currency,
                'value' => $start_amount,
            ],
            'upper_amount' => [
                'currency_code' => $currency,
                'value' => $end_amount,
            ],
        ];

        return $this;
    }

    /**
     * @param string $start_date
     * @param string $end_date
     * @param string $date_type
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function addInvoiceFilterByDateRange(string $start_date, string $end_date, string $date_type)
    {
        $start_date_obj = Carbon::parse($start_date);
        $end_date_obj = Carbon::parse($end_date);

        if ($start_date_obj->gt($end_date_obj)) {
            throw new \Exception('Starting date should always be less than the end date!');
        }

        if ( ! in_array($date_type, $this->invoices_date_types)) {
            throw new \Exception('date type should be always one of these: ' . implode(',', $this->invoices_date_types));
        }

        $this->invoiceSearchFilters["{$date_type}_range"] = [
            'start' => $start_date,
            'end' => $end_date,
        ];

        return $this;
    }

    /**
     * @param bool $archived
     *
     * @return $this
     */
    public function addInvoiceFilterByArchivedStatus(bool $archived = null)
    {
        $this->invoiceSearchFilters['archived'] = $archived;

        return $this;
    }

    /**
     * @param array $fields
     *
     * @return $this
     *
     * @see https://developer.paypal.com/docs/api/invoicing/v2/#definition-field
     */
    public function addInvoiceFilterByFields(array $fields)
    {
        $this->invoiceSearchFilters['status'] = $fields;

        return $this;
    }
}

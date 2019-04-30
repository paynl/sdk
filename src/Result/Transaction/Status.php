<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

class Status extends Result
{
    /**
     * @return string The EX-code of the transaction
     */
    public function getTransactionId()
    {
        return $this->data['paymentDetails']['transactionId'];
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->data['paymentDetails']['orderId'];
    }

    /**
     * @return int
     */
    public function getPaymentProfileId()
    {
        return $this->data['paymentDetails']['paymentProfileId'];
    }

    /**
     * @return int the status id
     */
    public function getState()
    {
        return $this->data['paymentDetails']['state'];
    }

    /**
     * @return string The name of the status
     */
    public function getStateName()
    {
        return $this->data['paymentDetails']['stateName'];
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->data['paymentDetails']['currency'];
    }

    /**
     * @return float|int The amount in euro
     */
    public function getAmount()
    {
        return $this->data['paymentDetails']['amount'] / 100;
    }

    /**
     * @return float|int The amount in the used currency
     */
    public function getCurrencyAmount()
    {
        return $this->data['paymentDetails']['currenyAmount'] / 100;
    }

    /**
     * @return float|int The paid amount
     */
    public function getPaidAmount()
    {
        return $this->data['paymentDetails']['paidAmount'] / 100;
    }

    /**
     * @return float|int The paid amount in the used currency
     */
    public function getPaidCurrencyAmount()
    {
        return $this->data['paymentDetails']['paidCurrenyAmount'] / 100;
    }

    /**
     * @return float|int The amount that has been refunded
     */
    public function getRefundedAmount()
    {
        return $this->data['paymentDetails']['refundAmount'] / 100;
    }

    /**
     * @return float|int The amount that has been refunded in the used currency
     */
    public function getRefundedCurrencyAmount()
    {
        return $this->data['paymentDetails']['refundCurrenyAmount'] / 100;
    }
}

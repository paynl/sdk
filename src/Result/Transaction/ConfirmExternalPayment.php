<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Result class for a Confirm External Payment
 *
 * @author Marcel Schoolenberg <marcelschoolenberg@gmail.com>
 */
class ConfirmExternalPayment extends Result
{
    /**
     * @return string The transactionId
     */
    public function getTransactionId()
    {
        return $this->data['transactionId'];
    }

    /**
     * @return string The CustomerId
     */
    public function getCustomerId()
    {
        return $this->data['customerId'];
    }

	/**
     * @return string The CustomerName
     */
    public function getCustomerName()
    {
        return $this->data['customerName'];
    }

	/**
     * @return string The PaymentType
     */
    public function getPaymentType()
    {
        return $this->data['paymentType'];
    }

	/**
     * @return boolean success
     */
    public function getSuccess()
    {
        return (boolean) $this->data['result'];
    }

	/**
     * @return string errorMessage
     */
    public function getErrorMessage()
    {
        return $this->data['errorMessage'];
    }

	/**
     * @return string errorId
     */
    public function getErrorId()
    {
        return $this->data['errorId'];
    }
}
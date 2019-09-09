<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

class Details extends Result
{
    /**
     * @return boolean
     */
    public function getResult()
    {
        return $this->data['request']['result'];
    }

    /**
     * @return string
     */
    public function getErrorId()
    {
        return $this->data['request']['errorId'];
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->data['request']['errorMessage'];
    }

    /**
     * @return string
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
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->data['paymentDetails']['orderNumber'];
    }

    /**
     * @return string
     */
    public function getStatsId()
    {
        return $this->data['paymentDetails']['statsId'];
    }

    /**
     * @return integer
     */
    public function getPaymentProfileId()
    {
        return $this->data['paymentDetails']['paymentProfileId'];
    }

    /**
     * @return string
     */
    public function getPaymentProfileName()
    {
        return $this->data['paymentDetails']['paymentProfileName'];
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->data['paymentDetails']['state'];
    }

    /**
     * @return string
     */
    public function getStateName()
    {
        return $this->data['paymentDetails']['stateName'];
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->data['paymentDetails']['language'];
    }

    /**
     * @return integer
     */
    public function getStartDate()
    {
        return $this->data['paymentDetails']['startDate'];
    }

    /**
     * @return integer
     */
    public function getCompleteDate()
    {
        return $this->data['paymentDetails']['completeDate'];
    }

    /**
     * @return string
     */
    public function getIdentifierName()
    {
        return $this->data['paymentDetails']['identifierName'];
    }

    /**
     * @return integer
     */
    public function getIdentifierType()
    {
        return $this->data['paymentDetails']['identifierType'];
    }

    /**
     * @return integer
     */
    public function getIdentifierPublic()
    {
        return $this->data['paymentDetails']['identifierPublic'];
    }

    /**
     * @return int
     */
    public function getIdentifierHash()
    {
        return $this->data['paymentDetails']['identifierHash'];
    }

    /**
     * @return string
     */
    public function getStartIpAddress()
    {
        return $this->data['paymentDetails']['startIpAddress'];
    }

    /**
     * @return string
     */
    public function getCompletedIpAddress()
    {
        return $this->data['paymentDetails']['completedIpAddress'];
    }

    /**
     * @return array
     */
    public function getAmount()
    {
        return $this->data['paymentDetails']['amount'];
    }

    /**
     * @return integer
     */
    public function getAmountOriginal()
    {
        return $this->data['paymentDetails']['amountOriginal'];
    }

    /**
     * @return integer
     */
    public function getAmountPaidOriginal()
    {
        return $this->data['paymentDetails']['amountPaidOriginal'];
    }

    /**
     * @return integer
     */
    public function getAmountPaid()
    {
        return $this->data['paymentDetails']['amountPaid'];
    }

    /**
     * @return integer
     */
    public function getAmountRefundOriginal()
    {
        return $this->data['paymentDetails']['amountRefundOriginal'];
    }

    /**
     * @return integer
     */
    public function getAmountRefund()
    {
        return $this->data['paymentDetails']['amountRefund'];
    }

    /**
     * @return array
     */
    public function getTransactionDetails()
    {
        return $this->data['paymentDetails']['transactionDetails'];
    }
}
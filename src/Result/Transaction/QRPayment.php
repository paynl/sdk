<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;


class QRPayment extends Result
{
    /**
     * @return string The id of the newly created transaction (EX-1234-5678-9012)
     */
    public function getTransactionId()
    {
        return $this->data['transaction']['transactionId'];
    }

    /**
     * @return string The orderId of the newly created transaction (123456789X12345)
     */
    public function getOrderId()
    {
        return $this->data['transaction']['orderId'];
    }

    /**
     * @return int The status id
     */
    public function getStateId()
    {
        return $this->data['transaction']['state'];
    }

    /**
     * @return string The status name
     */
    public function getStateName()
    {
        return $this->data['transaction']['stateName'];
    }

    /**
     * @return bool Transaction is paid
     */
    public function isPaid()
    {
        return $this->getStateName() === 'PAID';
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->getStateName() === 'PENDING' || $this->getStateName() === 'VERIFY';
    }

    /**
     * @return bool Transaction is Canceled
     */
    public function isCanceled()
    {
        return $this->getStateId() < 0;
    }
}

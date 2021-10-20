<?php

namespace Paynl\Api\Payment\Model;

class AuthenticateMethod extends Model
{
    /**
     * @var AbstractTransaction
     */
    private $transaction;

    /**
     * @var Payment
     */
    private $payment;

    /**
     * @return AbstractTransaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param AbstractTransaction $transaction
     * @return static
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param Payment $payment
     * @return static
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }
}
<?php

namespace Paynl\Api\Payment\Model;

use Paynl\Api\Payment\Model;

class Authorize extends Model\Model
{
    /**
     * @var Model\Authorize\Transaction;
     */
    private $transaction;

    /**
     * @var Model\Payment;
     */
    private $payment;

    /**
     * @return Authorize\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param Authorize\Transaction $transaction
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
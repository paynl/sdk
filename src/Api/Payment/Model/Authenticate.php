<?php

namespace Paynl\Api\Payment\Model;

class Authenticate extends Model
{
    /**
     * @var Authenticate\Transaction
     */
    private $transaction;

    /**
     * @var array
     */
    private $options;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var array
     */
    private $order;

    /**
     * @var array
     */
    private $stats;

    /**
     * @var Payment
     */
    private $payment;

    /**
     * @return Authenticate\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param Authenticate\Transaction $transaction
     * @return static
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return static
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return static
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param array $order
     * @return static
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return array
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param array $stats
     * @return static
     */
    public function setStats($stats)
    {
        $this->stats = $stats;
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
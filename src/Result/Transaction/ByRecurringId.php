<?php


namespace Paynl\Result\Transaction;


use Paynl\Result\Result;

class ByRecurringId extends Result
{

    private $transaction;

    public function __construct($data)
    {
        parent::__construct($data);

        $this->transaction = $data['transaction'];
    }

    public function getOrderId()
    {
        if (isset($this->transaction['orderId'])) return $this->transaction['orderId'];
        return null;
    }
    public function getEntranceCode()
    {
        if (isset($this->transaction['entranceCode'])) return $this->transaction['entranceCode'];
        return null;
    }

    public function getOrderAmount()
    {
        if (isset($this->transaction['orderAmount'])) return $this->transaction['orderAmount'];
        return null;
    }

    public function getOrderDescription()
    {
        if (isset($this->transaction['orderDescription'])) return $this->transaction['orderDescription'];
        return null;
    }
}
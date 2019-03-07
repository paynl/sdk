<?php

namespace Paynl\Result\DirectDebit;

use Paynl\Result\Result;

class Get extends Result
{
    protected function getOrder()
    {
        return $this->data['result']['order'];
    }

    public function getMandateId()
    {
        $order = $this->getOrder();
        return  $order['mandateId'];
    }
    public function getBankaccountNumber()
    {
        $order = $this->getOrder();
        return $order['bankaccountNumber'];
    }
    public function getBankaccountOwner()
    {
        $order = $this->getOrder();
        return $order['bankaccounOwner'];
    }
    public function getBankaccountBic()
    {
        $order = $this->getOrder();
        return $order['bankaccounBic'];
    }
    public function getAmount()
    {
        $order = $this->getOrder();
        return $order['amount']/100;
    }
    public function getDescription()
    {
        $order = $this->getOrder();
        return $order['description'];
    }
    public function getIpAddress()
    {
        $order = $this->getOrder();
        return $order['ipAddress'];
    }
    public function getEmail()
    {
        $order = $this->getOrder();
        return $order['email'];
    }
    public function getExtra1()
    {
        $order = $this->getOrder();
        return $order['extra1'];
    }
    public function getExtra2()
    {
        $order = $this->getOrder();
        return isset($order['extra2'])?$order['extra2']:'';
    }
    public function getExtra3()
    {
        $order = $this->getOrder();
        return isset($order['extra3'])?$order['extra3']:'';
    }
}

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
        return ($this->getOrder())['mandateId'];
    }
    public function getBankaccountNumber()
    {
        return ($this->getOrder())['bankaccountNumber'];
    }
    public function getBankaccountOwner()
    {
        return ($this->getOrder())['bankaccounOwner'];
    }
    public function getBankaccountBic()
    {
        return ($this->getOrder())['bankaccounBic'];
    }
    public function getAmount()
    {
        return ($this->getOrder())['amount']/100;
    }
    public function getDescription()
    {
        return ($this->getOrder())['description'];
    }
    public function getIpAddress()
    {
        return ($this->getOrder())['ipAddress'];
    }
    public function getEmail()
    {
        return ($this->getOrder())['email'];
    }
    public function getExtra1()
    {
        return ($this->getOrder())['extra1'];
    }
    public function getExtra2()
    {
        return isset(($this->getOrder())['extra2'])?($this->getOrder())['extra2']:'';
    }
    public function getExtra3()
    {
        return isset(($this->getOrder())['extra3'])?($this->getOrder())['extra3']:'';
    }
}

<?php

namespace Paynl\Result\Voucher;

use Paynl\Result\Result;

class Voucher extends Result
{
    /**
     * Returns the balance for the voucher
     * @return float the current balance of the voucher
     */
    public function getBalance()
    {
        return $this->data['balance'] / 100;
    }

    /**
     * Returns the voucher code
     * @return string
     */
    public function getCardNumber()
    {
        return $this->data['cardNumber'];
    }

    /**
     * refresh the internal data
     */
    private function _reload()
    {
        $this->data = \Paynl\Voucher::get($this->getCardNumber())->getData();
    }

    /**
     * provide functionality to charge the voucher from this instance
     *
     * @param float $amount the amount to charge the voucher with
     * @param string $pin the pin code for the voucher
     * @return bool if the charge was done succesfully
     */
    public function charge($amount, $pin)
    {
        $state = \Paynl\Voucher::charge(array(
          'cardNumber' => $this->getCardNumber(),
          'amount' => $amount,
          'pincode' => $pin
        ));
        $this->_reload();
        return $state;
    }
}

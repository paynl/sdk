<?php

namespace Paynl\Api\Voucher;

use Paynl\Error\Error;
use Paynl\Error\Required as ErrorRequired;

class Charge extends Voucher
{

    protected $apiTokenRequired = true;
    protected $serviceIdRequired = false;

    /**
     * @var string The voucher card number
     */
    private $_cardNumber;
    /**
     * @var string The voucher pin doe (if required)
     */
    private $_pincode;
    /**
     * @var string The voucher pin doe (if required)
     */
    private $_amount;

    /**
     * @param string $cardNumber
     */
    public function setCardNumber($cardNumber)
    {
        $this->_cardNumber = $cardNumber;
    }

    /**
     * @param string $pincode
     */
    public function setPincode($pincode)
    {
        $this->_pincode = $pincode;
    }

    /**
     * Set the amount(in cents) of the transaction
     *
     * @param int $amount
     *
     * @throws Error
     */
    public function setAmount($amount)
    {
        if (is_numeric($amount)) {
            $this->_amount = $amount;
        } else {
            throw new Error('Amount is niet numeriek', 1);
        }
    }

    protected function getData()
    {
        if (empty($this->_cardNumber)) {
            throw new ErrorRequired('cardNumber is niet geset', 1);
        } else {
            $data['cardNumber'] = $this->_cardNumber;
        }

        if (!empty($this->_pincode)) {
            $data['pincode'] = $this->_pincode;
        }

        if (empty($this->_amount)) {
            throw new ErrorRequired('Amount is niet geset', 1);
        } else {
            $data['amount'] = $this->_amount;
        }

        $this->data = array_merge($data, $this->data);

        return parent::getData();
    }

    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('voucher/charge');
    }
}
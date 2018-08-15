<?php

namespace Paynl\Api\Voucher;

use Paynl\Error\Error;
use Paynl\Error\Required;

class Charge extends Voucher
{
    protected $apiTokenRequired = true;

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
        if (!is_numeric($amount)) {
            throw new Error('Amount is niet numeriek', 1);
        }
        $this->_amount = $amount;
    }

    /**
     * @inheritdoc
     * @throws Required cardNumber is required
     * @throws Required amount is required
     */
    protected function getData()
    {
        if (empty($this->_cardNumber)) {
            throw new Required('cardNumber is required', 1);
        }
        if (empty($this->_amount)) {
            throw new Required('amount is required', 1);
        }

        $data['amount'] = $this->_amount;
        $data['cardNumber'] = $this->_cardNumber;

        if (!empty($this->_pincode)) {
            $data['pincode'] = $this->_pincode;
        }

        $this->data = array_merge($data, $this->data);

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('voucher/charge');
    }
}

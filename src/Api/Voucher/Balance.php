<?php

namespace Paynl\Api\Voucher;

use Paynl\Error\Required as ErrorRequired;

class Balance extends Voucher
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

    protected function getData()
    {
        if(!empty($this->_pincode)){
            $data['pincode'] = $this->_pincode;
        }
        if(empty($this->_cardNumber)){
            throw new ErrorRequired('cardNumber is niet geset', 1);
        }else{
            $data['cardNumber'] = $this->_cardNumber;
        }

        $this->data = array_merge($data, $this->data);

        return parent::getData();
    }

    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('voucher/balance');
    }
}
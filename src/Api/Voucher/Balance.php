<?php

namespace Paynl\Api\Voucher;

use Paynl\Error\Required;

class Balance extends Voucher
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
     * @inheritdoc
     * @throws Required cardNumber is required
     */
    protected function getData()
    {
        if (empty($this->_cardNumber)) {
            throw new Required('cardNumber is required', 1);
        }

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
        return parent::doRequest('voucher/balance');
    }
}

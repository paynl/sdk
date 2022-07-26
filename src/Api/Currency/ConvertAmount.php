<?php

namespace Paynl\Api\Currency;

use Paynl\Error\Required;

class ConvertAmount extends Currency
{
    private $_sourceCurrencyId = null;
    private $_targetCurrencyId = null;
    private $_amount = null;

    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    public function setTargetCurrencyId($targetCurrencyId)
    {
        $this->_targetCurrencyId = $targetCurrencyId;
    }

    public function setSourceCurrencyId($sourceCurrencyId)
    {
        $this->_sourceCurrencyId = $sourceCurrencyId;
    }

    public function getData()
    {
        //if (empty($this->_mandateId)) {
//            throw new Required('mandateId');
//        }

        $this->data['sourceCurrencyId'] = $this->_sourceCurrencyId;
        $this->data['targetCurrencyId'] = $this->_targetCurrencyId;
        $this->data['amount'] = $this->_amount;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Currency/convertAmount', $version);
    }
}

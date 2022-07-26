<?php

namespace Paynl\Api\Currency;

use Paynl\Error\Required;

class ConvertAmount extends Currency
{
    private $_sourceCurrencyId = null;
    private $_targetCurrencyId = null;
    private $_amount = null;

    /**
     * @param $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = $amount;
    }

    /**
     * @param $targetCurrencyId
     */
    public function setTargetCurrencyId($targetCurrencyId)
    {
        $this->_targetCurrencyId = $targetCurrencyId;
    }

    /**
     * @param $sourceCurrencyId
     */
    public function setSourceCurrencyId($sourceCurrencyId)
    {
        $this->_sourceCurrencyId = $sourceCurrencyId;
    }

    public function getData()
    {
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

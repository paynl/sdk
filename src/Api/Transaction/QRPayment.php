<?php

namespace Paynl\Api\Transaction;


use Paynl\Error\InvalidArgument;
use Paynl\Error\Required;
class QRPayment extends Transaction
{
    protected $apiTokenRequired = true;
    protected $serviceIdRequired = true;

    /**
     * @var string The scan data of the QR code consisting of 18 numbers and should start with 10, 11, 12, 13, 14 or 15
     */
    private $_scanData;
    /**
     * @var integer The amount to be paid should be given in cents. For example € 3.50 becomes 350.
     */
    private $_amount;
    /**
     * @var string Description for the transaction. Max length of the description is 128 characters.
     */
    private $_description;

    /**
     * @var string The currency of the transaction. If omitted, EUR is used. A list with available currency names and id's can be obtained at: API_Currency_v2::getAll()
     */
    private $_currency;

    /**
     * @var array
     */
    private $_statsData;

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = substr($description, 0, 128);
    }


    /**
     * @return string|null
     */
    public function getScanData()
    {
        return $this->_scanData;
    }

    /**
     * @param string $scanData
     */
    public function setScanData($scanData)
    {
        $this->_scanData = $scanData;
    }

    /**
     * @return integer|null
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @param integer $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = (int)$amount;
    }

    /**
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    /**
     * @param string $currency
     * @throws InvalidArgument
     */
    public function setCurrency($currency)
    {
        if(strlen($currency) != 3) throw new InvalidArgument('Currency must be 3 characters long');
        $this->_currency = strtoupper($currency);
    }

    /**
     * @return array|null
     */
    public function getStatsData()
    {
        return $this->_statsData;
    }

    /**
     * @param array $statsData
     */
    public function setStatsData($statsData)
    {
        $this->_statsData = $statsData;
    }

    protected function getData()
    {
        //check for required fields
        if (empty($this->getScanData())) throw new Required('scanData');
        if (empty($this->getAmount())) throw new Required('amount');
        if (empty($this->getDescription())) throw new Required('description');

        $this->data['scanData'] = $this->getScanData();
        $this->data['amount'] = $this->getAmount();
        $this->data['description'] = $this->getDescription();
        if($this->getCurrency() != null){
            $this->data['currency'] = $this->getCurrency();
        }

        if($this->getStatsData() != null){
            $this->data['statsData'] = $this->getStatsData();
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/QRpayment');
    }

}
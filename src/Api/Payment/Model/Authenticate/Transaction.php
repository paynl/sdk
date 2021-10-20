<?php

namespace Paynl\Api\Payment\Model\Authenticate;

use Paynl\Api\Payment\Model\AbstractTransaction;

class Transaction extends AbstractTransaction
{
    /**
     * @var string
     */
    private $type = 'ecom';

    /**
     * @var string
     */
    private $serviceId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $exchangeUrl;

    /**
     * @var string
     */
    private $finishUrl;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return static
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param string $serviceId
     * @return static
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return static
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return static
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     * @return static
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return static
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return static
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return static
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getExchangeUrl()
    {
        return $this->exchangeUrl;
    }

    /**
     * @param string $exchangeUrl
     * @return static
     */
    public function setExchangeUrl($exchangeUrl)
    {
        $this->exchangeUrl = $exchangeUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getFinishUrl()
    {
        return $this->finishUrl;
    }

    /**
     * @param string $finishUrl
     * @return static
     */
    public function setFinishUrl($finishUrl)
    {
        $this->finishUrl = $finishUrl;
        return $this;
    }
}
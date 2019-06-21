<?php


namespace Paynl\Api\Transaction;


use Paynl\Error\Required;

class ByRecurringId extends Transaction
{
    protected $version = 13;

    protected $serviceIdRequired = true;
    protected $apiTokenRequired = true;

    /** @var string */
    private $recurringId;
    /** @var integer */
    private $amount;
    /** @var string */
    private $currency;
    /** @var string */
    private $description;
    /** @var string */
    private $cvc;
    /** @var array */
    private $statsData;

    /**
     * @return string
     */
    public function getRecurringId()
    {
        return $this->recurringId;
    }

    /**
     * @param string $recurringId
     */
    public function setRecurringId($recurringId)
    {
        $this->recurringId = $recurringId;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
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
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * @param string $cvc
     */
    public function setCvc($cvc)
    {
        $this->cvc = $cvc;
    }

    /**
     * @return array
     */
    public function getStatsData()
    {
        return $this->statsData;
    }

    /**
     * @param array $statsData
     */
    public function setStatsData($statsData)
    {
        $this->statsData = $statsData;
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/byRecurringId');
    }

    /** @inheritdoc */
    protected function getData()
    {
        if (empty($this->recurringId)) throw new Required('recurringId');
        $this->data['recurringId'] = $this->recurringId;

        if (empty($this->amount)) throw new Required('amount');
        $this->data['amount'] = round($this->amount * 100);

        if (!empty($this->currency)) $this->data['currency'] = $this->currency;
        if (!empty($this->description)) $this->data['description'] = $this->description;
        if (!empty($this->cvc)) $this->data['cvc'] = $this->cvc;
        if (is_array($this->statsData) && !empty($this->statsData)) $this->data['statsData'] = $this->statsData;

        return parent::getData();
    }
}
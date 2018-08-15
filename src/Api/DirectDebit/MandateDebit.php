<?php

namespace Paynl\Api\DirectDebit;

use Paynl\Error\Required;

class MandateDebit extends DirectDebit
{
    protected $apiTokenRequired = true;

    /**
     * @var string The mandateId (IO-xxxx-xxxx-xxxx)
     */
    private $_mandateId;
    /**
     * @var int The amount of the recurring directdebit. If not present, the amount of the last directdebit will be used.
     */
    private $_amount;
    /**
     * @var string The description for the recurring directdebit. If not present, the description of the last directdebit will be used.
     */
    private $_description;
    /**
     * @var \DateTime The processDate of the recurring directdebit. If not present, it will be processed as soon as possible.
     */
    private $_processDate;
    /**
     * @var boolean Indicate wether this is the last directdebit for this mandateId.
     */
    private $_last;

    /**
     * @param string $mandateId
     */
    public function setMandateId($mandateId)
    {
        $this->_mandateId = $mandateId;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->_amount = (int)$amount;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @param \DateTime $processDate
     */
    public function setProcessDate(\DateTime $processDate)
    {
        $this->_processDate = $processDate;
    }

    /**
     * @param boolean $last
     */
    public function setLast($last)
    {
        $this->_last = $last;
    }

    /**
     * @inheritdoc
     * @throws Required mandateId is required
     */
    protected function getData()
    {
        if (empty($this->_mandateId)) {
            throw new Required('mandateId');
        }

        $this->data['mandateId'] = $this->_mandateId;

        if (!empty($this->_amount)) {
            $this->data['amount'] = $this->_amount;
        }
        if (!empty($this->_description)) {
            $this->data['description'] = $this->_description;
        }
        if ($this->_processDate instanceof \DateTime) {
            $this->data['processDate'] = $this->_processDate->format('d-m-Y');
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('DirectDebit/mandateDebit');
    }
}

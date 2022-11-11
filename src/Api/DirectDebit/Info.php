<?php

namespace Paynl\Api\DirectDebit;

use Paynl\Error\Required;

class Info extends DirectDebit
{
    protected $apiTokenRequired = true;

    /**
     * @var string The mandate id (IO-xxxx-xxxx-xxxx)
     */
    private $_mandateId;

    /**
     * @var string The reference id (IL-xxxx-xxxx-xxxx)
     */
    private $_referenceId;

    /**
     * @param string $mandateId The mandate id (IO-xxxx-xxxx-xxxx)
     */
    public function setMandateId($mandateId)
    {
        $this->_mandateId = $mandateId;
    }

    /**
     * @param string $referenceId The reference id (IL-xxxx-xxxx-xxxx)
     */
    public function setReferenceId($referenceId)
    {
        $this->_referenceId = $referenceId;
    }

    /**
     * @inheritdoc
     * @throws Required mandateId is required
     */
    public function getData()
    {
        if (empty($this->_mandateId)) {
            throw new Required('mandateId');
        }

        $this->data['mandateId'] = $this->_mandateId;
        if (!empty($this->_referenceId)) {
            $this->data['referenceId'] = $this->_referenceId;
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('DirectDebit/info');
    }
}

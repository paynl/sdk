<?php

namespace Paynl\Api\DirectDebit;

class MandateGet extends DirectDebit
{
    protected $apiTokenRequired = true;

    /**
     * @var string The mandate id (IO-xxxx-xxxx-xxxx)
     */
    private $_mandateId;

    /**
     * @param string $mandateId The mandate id (IO-xxxx-xxxx-xxxx)
     */
    public function setMandateId($mandateId)
    {
        $this->_mandateId = $mandateId;
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->data['mandateId'] = $this->_mandateId;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('DirectDebit/mandateGet');
    }
}

<?php

namespace Paynl\Api\DirectDebit;

use Paynl\Error\Required;

class DebitGet extends DirectDebit
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
     * @throws Required mandateId is required
     */
    public function getData()
    {
        if (empty($this->_mandateId)) {
            throw new Required('mandateId');
        }

        $this->data['mandateId'] = $this->_mandateId;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('DirectDebit/debitGet');
    }
}

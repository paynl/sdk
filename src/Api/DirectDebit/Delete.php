<?php

namespace Paynl\Api\DirectDebit;

use Paynl\Error\Required;

class Delete extends DirectDebit
{
    /**
     * @var string The mandateId of the directdebit.
     */
    private $_mandateId;

    /**
     * @param string $mandateId The mandateId of the directdebit.
     */
    public function setMandateId($mandateId)
    {
        $this->_mandateId = $mandateId;
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

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('DirectDebit/delete');
    }
}

<?php

namespace Paynl\Api\Transaction;

use Paynl\Error;

class Status extends Transaction
{
    protected $apiTokenRequired = true;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * Set the transactionId
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/status');
    }

    /**
     * @inheritdoc
     * @throws Error\Required TransactionId is required
     */
    protected function getData()
    {
        if (empty($this->transactionId)) {
            throw new Error\Required('TransactionId required');
        }

        $this->data['transactionId'] = $this->transactionId;

        return parent::getData();
    }
}

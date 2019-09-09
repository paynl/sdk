<?php

namespace Paynl\Api\Transaction;

use Paynl\Error;

class Details extends Transaction
{
    protected $apiTokenRequired = true;

    /**
     * @var int
     */
    private $transactionId;

    /**
     * @var int
     */
    private $entranceCode;

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
     * Set the entranceCode
     *
     * @param $entranceCode
     */
    public function setEntranceCode($entranceCode)
    {
        $this->entranceCode = $entranceCode;
    }

    /**
     * @inheritdoc
     * @throws Error\Required TransactionId is required
     */
    protected function getData()
    {
        if (empty($this->transactionId)) {
            throw new Error\Required('TransactionId is required');
        }
        $this->data['transactionId'] = $this->transactionId;

        if (!empty($this->entranceCode)) $this->data['entranceCode'] = $this->entranceCode;


        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/details', 14);
    }
}

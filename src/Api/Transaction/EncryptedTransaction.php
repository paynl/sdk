<?php

namespace Paynl\Api\Transaction;

use Paynl\Api\Api;

/**
 * Encrypted transaction
 *
 * @author Michael Roterman <michael@pay.nl>
 */
class EncryptedTransaction extends Api
{
    private $transactionId;
    private $payload;

    /**
     * @var int the version of the api
     */
    protected $version = 2;

    public function getData()
    {
        return array_merge(parent::getData(), array(
            'transactionId' => $this->transactionId,
            'payload' => $this->payload
        ));
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('creditcard/captureWithEncryptedData');
    }
}

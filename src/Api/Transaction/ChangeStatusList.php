<?php

namespace Paynl\Api\Transaction;

use Paynl\Error;

class ChangeStatusList extends Transaction
{
    protected $apiTokenRequired = true;

    /**
     * @var int
     */
    private $timestamp;

    /**
     * Set the timestamp
     *
     * @param $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @inheritdoc
     * @throws Error\Required Timestamp is required
     */
    protected function getData()
    {
        if (empty($this->timestamp)) {
            throw new Error\Required('Timestamp is required');
        }
        $this->data['timestamp'] = $this->timestamp;


        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/changeStatusList', 14);
    }
}

<?php

namespace Paynl\Api\Transaction;

use Paynl\Error;
use Paynl\Helper;

/**
 * Api class to refund a transaction
 *
 * @author PAY. <support@pay.nl>
 */
class Cancel extends Transaction
{
    protected $apiTokenRequired = true;

    protected $version = 15;

    /**
     * @var string The order ID of the transaction
     */
    private $transactionId;
    /**
     * @var string Unique code related to the order.
     */
    private $entranceCode;
   

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }   

    /**
     * @param int $entranceCode
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
       
        if (!empty($this->entranceCode)) {
            $this->data['entranceCode'] = $this->entranceCode;
        }

        return parent::getData();
    }

    /**
     * @param object|array $result
     *
     * @return array
     * @throws Error\Api
     */
    protected function processResult($result)
    {
        $output = Helper::objectToArray($result);

        if (!is_array($output)) {
            throw new Error\Api($output);
        }

        if (
            isset($output['request']) &&
            $output['request']['result'] != 1 &&
            $output['request']['result'] !== 'TRUE') {
            throw new Error\Api($output['request']['errorId'] . ' - ' . $output['request']['errorMessage']. ' '. (isset($output['description']) ? $output['description'] : ''));
        }

        return parent::processResult($result);
    }
    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/cancel');
    }
}

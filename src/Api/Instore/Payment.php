<?php

namespace Paynl\Api\Instore;

use Paynl\Error;

/**
 * Description of Status
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Payment extends Instore
{
    protected $apiTokenRequired = true;

    /**
     * @var string the TransactionId
     */
    private $transactionId;

    /**
     * @var string the terminalId
     */
    private $terminalId;

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @param string $terminalId
     */
    public function setTerminalId($terminalId)
    {
        $this->terminalId = $terminalId;
    }

    /**
     * @inheritdoc
     * @throws Error\Required transactionId is required
     */
    protected function getData()
    {
        if (empty($this->transactionId)) {
            throw new Error\Required('transactionId is required');
        }

        $this->data['transactionId'] = $this->transactionId;

        if (!empty($this->terminalId)) {
            $this->data['terminalId'] = $this->terminalId;
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('instore/payment');
    }
}

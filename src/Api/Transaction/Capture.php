<?php

namespace Paynl\Api\Transaction;

use Paynl\Error;

/**
 * Description of Approve
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Capture extends Transaction
{
    protected $version = 12;
    protected $apiTokenRequired = true;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var int amount in cents
     */
    private $amount;

    /**
     * @var string
     */
    private $tracktrace;

    /**
     * @var array
     */
    private $products;

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
     * Set the amount(in cents) of the transaction
     *
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Set the track and trace code
     *
     * @param string $tracktrace
     */
    public function setTracktrace($tracktrace)
    {
        $this->tracktrace = $tracktrace;
    }

    /**
     * Set the products
     *
     * @param array $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @inheritdoc
     * @throws Error\Required TransactionId is required
     */
    protected function getData()
    {
        if (empty($this->transactionId)) {
            throw new Error\Required('TransactionId is niet geset');
        }

        $this->data['transactionId'] = $this->transactionId;

        if(!empty($this->amount)){
            $this->data['amount'] = $this->amount;
        }

        if(!empty($this->tracktrace)){
            $this->data['tracktrace'] = $this->tracktrace;
        }

        if (!empty($this->products)) {
            $this->data['products'] = $this->products;
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/capture');
    }
}

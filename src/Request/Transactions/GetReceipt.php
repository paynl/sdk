<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class GetReceipt extends AbstractRequest
{
    use TransactionIdTrait;

    /**
     * GetReceipt constructor.
     *
     * @param string $transactionId
     */
    public function __construct(string $transactionId)
    {
        $this->setTransactionId($transactionId);
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'transactions/' . $this->getTransactionId() . '/receipt';
    }
}

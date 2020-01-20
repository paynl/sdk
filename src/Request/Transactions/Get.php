<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest,
    Request\Parameter\TransactionIdTrait
};

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Get extends AbstractRequest
{
    use TransactionIdTrait;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $transactionId = (string)$this->getParam('transactionId');
        if (null === $transactionId) {
            throw new MissingParamException('Missing param!');
        }
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
        return 'transactions/' . $this->getTransactionId();
    }
}

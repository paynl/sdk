<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\Model\Terminal;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;

/**
 * Class CreatePayment
 *
 * @package PayNL\Sdk\Request\Pin
 */
class PayTransaction extends AbstractRequest
{
    use TransactionIdTrait;

    public function __construct(string $transactionId, Terminal $terminal)
    {
        $this->setTransactionId($transactionId)
            ->setBody($terminal)
        ;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "pin/{$this->getTransactionId()}/payment";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }
}

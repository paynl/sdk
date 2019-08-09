<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

/**
 * Class Approve
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Approve extends StatusChange
{
    /**
     * Approve constructor.
     *
     * @param string $transactionId
     *
     */
    public function __construct(string $transactionId)
    {
        $this->setTransactionId($transactionId);
        $this->setStatus(static::STATUS_APPROVE);
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }

}
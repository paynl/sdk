<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

/**
 * Class Approve
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Decline extends StatusChange
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
        $this->setStatus(static::STATUS_DECLINE);
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }

}
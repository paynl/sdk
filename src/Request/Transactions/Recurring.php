<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;
use PayNL\Sdk\Model\RecurringTransaction;

/**
 * Class Recurring
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Recurring extends AbstractRequest
{
    use TransactionIdTrait;

    /**
     * Recurring constructor.
     *
     * @param string $transactionId
     * @param RecurringTransaction $recurringTransaction
     */
    public function __construct(string $transactionId, RecurringTransaction $recurringTransaction)
    {
        $this->setTransactionId($transactionId)
            ->setBody($recurringTransaction)
        ;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "transactions/{$this->getTransactionId()}/recurring";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }

}

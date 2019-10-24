<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Model\Transaction;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Transformer\Transaction as TransactionTransformer;
use PayNL\Sdk\Transformer\TransformerInterface;

/**
 * Class Create
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Create extends AbstractRequest
{
    /**
     * Create constructor.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->setBody($transaction);
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'transactions';
    }

    /**
     * @return TransactionTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new TransactionTransformer();
    }
}

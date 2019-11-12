<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Model\Refund as RefundModel,
    Transformer\TransformerInterface,
    Transformer\Refund as RefundTransformer
};
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;

/**
 * Class Refund
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Refund extends AbstractRequest
{
    use TransactionIdTrait;

    /**
     * Refund constructor.
     *
     * @param string $transactionId
     * @param RefundModel $refund
     */
    public function __construct(string $transactionId, RefundModel $refund)
    {
        $this->setTransactionId($transactionId)
            ->setBody($refund)
        ;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "transactions/{$this->getTransactionId()}/refund";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }

    /**
     * @return RefundTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new RefundTransformer();
    }
}

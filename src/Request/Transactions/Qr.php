<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Transaction as TransactionTransformer
};
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;

/**
 * Class QR
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Qr extends AbstractRequest
{
    use TransactionIdTrait;

    /**
     * QR constructor.
     *
     * @param string $transactionId
     * @param string $scanDataQRCode
     */
    public function __construct(string $transactionId, string $scanDataQRCode)
    {
        $this->setTransactionId($transactionId)
            ->setBody((object)[
                'scanData' => $scanDataQRCode,
            ])
        ;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "transactions/{$this->getTransactionId()}/qr";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }

    /**
     * @return TransactionTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new TransactionTransformer();
    }
}

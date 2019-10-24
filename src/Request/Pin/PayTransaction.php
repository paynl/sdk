<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Model\Terminal,
    Transformer\TransformerInterface,
    Transformer\TerminalTransaction as TerminalTransactionTransformer
};
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;

/**
 * Class CreatePayment
 *
 * @package PayNL\Sdk\Request\Pin
 */
class PayTransaction extends AbstractRequest
{
    use TransactionIdTrait;

    /**
     * PayTransaction constructor.
     *
     * @param string $transactionId
     * @param Terminal $terminal
     */
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

    /**
     * @return TerminalTransactionTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new TerminalTransactionTransformer();
    }
}

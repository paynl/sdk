<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Receipt as ReceiptTransformer
};
use PayNL\Sdk\Request\Parameter\TerminalTransactionIdTrait;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class GetReceipt extends AbstractRequest
{
    use TerminalTransactionIdTrait;

    /**
     * GetReceipt constructor.
     *
     * @param string $terminalTransactionId
     */
    public function __construct(string $terminalTransactionId)
    {
        $this->setTerminalTransactionId($terminalTransactionId);
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
        return "pin/{$this->getTerminalTransactionId()}/receipt";
    }

    /**
     * @return ReceiptTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new ReceiptTransformer();
    }
}

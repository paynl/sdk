<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\Model\TerminalTransaction;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\TerminalTransactionIdTrait;

/**
 * Class ConfirmTerminalTransaction
 *
 * @package PayNL\Sdk\Request\Pin
 */
class ConfirmTerminalTransaction extends AbstractRequest
{
    use TerminalTransactionIdTrait;

    public function __construct(string $terminalTransactionId, TerminalTransaction $terminalTransaction)
    {
        $this->setTerminalTransactionId($terminalTransactionId)
            ->setBody($terminalTransaction)
        ;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "pin/{$this->getTerminalTransactionId()}/confirm";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }
}

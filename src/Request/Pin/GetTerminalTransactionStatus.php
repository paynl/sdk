<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\TerminalTransactionIdTrait;

/**
 * Class GetStatus
 *
 * @package PayNL\Sdk\Request\Pin
 */
class GetTerminalTransactionStatus extends AbstractRequest
{
    use TerminalTransactionIdTrait;

    public function __construct(string $terminalTransactionId)
    {
        $this->setTerminalTransactionId($terminalTransactionId);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "pin/{$this->getTerminalTransactionId()}/status";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }
}

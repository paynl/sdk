<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest,
    Request\Parameter\TerminalTransactionIdTrait
};

/**
 * Class GetStatus
 *
 * @package PayNL\Sdk\Request\Pin
 */
class GetTerminalTransactionStatus extends AbstractRequest
{
    use TerminalTransactionIdTrait;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $terminalTransactionId = (string)$this->getParam('terminalTransactionId');
        if (null === $terminalTransactionId) {
            throw new MissingParamException('Missing param!');
        }

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

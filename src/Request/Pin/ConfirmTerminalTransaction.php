<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest,
    Request\Parameter\TerminalTransactionIdTrait
};

/**
 * Class ConfirmTerminalTransaction
 *
 * @package PayNL\Sdk\Request\Pin
 */
class ConfirmTerminalTransaction extends AbstractRequest
{
    use TerminalTransactionIdTrait;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $terminalTransactionId = (string)$this->getParam('terminalTransactionId');
        if (true === empty($terminalTransactionId)) {
            throw new MissingParamException(
                'Missing terminal transaction id'
            );
        }

        $this->setTerminalTransactionId($terminalTransactionId);
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

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Parameter;

/**
 * Class TerminalTransactionIdTrait
 *
 * @package PayNL\Sdk\Request\Parameter
 */
trait TerminalTransactionIdTrait
{
    /**
     * @var string
     */
    protected $terminalTransactionId;

    /**
     * @return string
     */
    public function getTerminalTransactionId(): string
    {
        return $this->terminalTransactionId;
    }

    /**
     * @param string $terminalTransactionId
     *
     * @return TerminalTransactionIdTrait
     */
    public function setTerminalTransactionId(string $terminalTransactionId): self
    {
        $this->terminalTransactionId = $terminalTransactionId;
        return $this;
    }
}

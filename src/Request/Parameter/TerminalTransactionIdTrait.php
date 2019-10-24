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
        return (string)$this->terminalTransactionId;
    }

    /**
     * @param string $terminalTransactionId
     *
     * @return static
     */
    public function setTerminalTransactionId(string $terminalTransactionId): self
    {
        $this->terminalTransactionId = $terminalTransactionId;
        return $this;
    }
}

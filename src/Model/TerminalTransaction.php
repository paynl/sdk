<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;

/**
 * Class TerminalTransaction
 *
 * @package PayNL\Sdk\Model
 */
class TerminalTransaction implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait, LinksTrait;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $terminalTransactionId;

    /**
     * @var string
     */
    protected $transactionHash;

    /**
     * @var string
     */
    protected $issuerUrl;

    /**
     * @var string
     */
    protected $statusUrl;

    /**
     * @var string
     */
    protected $cancelUrl;

    /**
     * @var string
     */
    protected $nextUrl;

    /**
     * @var Terminal
     */
    protected $terminal;

    /**
     * @var Progress
     */
    protected $progress;

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return TerminalTransaction
     */
    public function setState(string $state): self
    {
        $this->state = $state;
        return $this;
    }

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
     * @return TerminalTransaction
     */
    public function setTerminalTransactionId(string $terminalTransactionId): self
    {
        $this->terminalTransactionId = $terminalTransactionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionHash(): string
    {
        return $this->transactionHash;
    }

    /**
     * @param string $transactionHash
     *
     * @return TerminalTransaction
     */
    public function setTransactionHash(string $transactionHash): self
    {
        $this->transactionHash = $transactionHash;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssuerUrl(): string
    {
        return $this->issuerUrl;
    }

    /**
     * @param string $issuerUrl
     *
     * @return TerminalTransaction
     */
    public function setIssuerUrl(string $issuerUrl): self
    {
        $this->issuerUrl = $issuerUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusUrl(): string
    {
        return $this->statusUrl;
    }

    /**
     * @param string $statusUrl
     *
     * @return TerminalTransaction
     */
    public function setStatusUrl(string $statusUrl): self
    {
        $this->statusUrl = $statusUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    /**
     * @param string $cancelUrl
     *
     * @return TerminalTransaction
     */
    public function setCancelUrl(string $cancelUrl): self
    {
        $this->cancelUrl = $cancelUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getNextUrl(): string
    {
        return $this->nextUrl;
    }

    /**
     * @param string $nextUrl
     *
     * @return TerminalTransaction
     */
    public function setNextUrl(string $nextUrl): self
    {
        $this->nextUrl = $nextUrl;
        return $this;
    }

    /**
     * @return Terminal
     */
    public function getTerminal(): Terminal
    {
        return $this->terminal;
    }

    /**
     * @param Terminal $terminal
     *
     * @return TerminalTransaction
     */
    public function setTerminal(Terminal $terminal): self
    {
        $this->terminal = $terminal;
        return $this;
    }

    /**
     * @return Progress
     */
    public function getProgress(): Progress
    {
        return $this->progress;
    }

    /**
     * @param Progress $progress
     *
     * @return TerminalTransaction
     */
    public function setProgress(Progress $progress): self
    {
        $this->progress = $progress;
        return $this;
    }
}

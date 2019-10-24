<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Parameter;

/**
 * Trait TransactionIdTrait
 *
 * @package PayNL\Sdk\Request\Parameter
 */
trait TransactionIdTrait
{
    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return (string)$this->transactionId;
    }

    /**
     * @param string $transactionId
     *
     * @return static
     */
    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }
}

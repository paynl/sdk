<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Directdebit
 *
 * @package PayNL\Sdk\Model
 */
class Directdebit implements ModelInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $paymentSessionId;

    /**
     * @var Amount
     */
    protected $amount;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var BankAccount
     */
    protected $bankAccount;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var Status
     */
    protected $declined;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Directdebit
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentSessionId(): string
    {
        return $this->paymentSessionId;
    }

    /**
     * @param string $paymentSessionId
     *
     * @return Directdebit
     */
    public function setPaymentSessionId(string $paymentSessionId): self
    {
        $this->paymentSessionId = $paymentSessionId;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    /**
     * @param Amount $amount
     *
     * @return Directdebit
     */
    public function setAmount(Amount $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->description;
    }

    /**
     * @param string $description
     *
     * @return Directdebit
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return BankAccount
     */
    public function getBankAccount(): BankAccount
    {
        return $this->bankAccount;
    }

    /**
     * @param BankAccount $bankAccount
     *
     * @return Directdebit
     */
    public function setBankAccount(BankAccount $bankAccount): self
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     *
     * @return Directdebit
     */
    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Status
     */
    public function getDeclined(): ?Status
    {
        return $this->declined;
    }

    /**
     * @param Status $declined
     *
     * @return Directdebit
     */
    public function setDeclined(Status $declined): self
    {
        $this->declined = $declined;
        return $this;
    }
}

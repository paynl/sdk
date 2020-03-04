<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use DateTime;
use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Refund
 *
 * @package PayNL\Sdk\Model
 */
class Refund implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait, LinksTrait;

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
    protected $description = '';

    /**
     * @var BankAccount
     */
    protected $bankAccount;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var Products
     */
    protected $products;

    /**
     * @var string
     */
    protected $reason = '';

    /**
     * @var DateTime
     */
    protected $processDate;

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
     * @return Refund
     */
    public function setId(string $id): Refund
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentSessionId(): string
    {
        return (string)$this->paymentSessionId;
    }

    /**
     * @param string $paymentSessionId
     *
     * @return Refund
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
     * @return Refund
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
     * @return Refund
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
     * @return Refund
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
     * @return Refund
     */
    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Products
     */
    public function getProducts(): Products
    {
        if (null === $this->products) {
            $this->setProducts(new Products());
        }
        return $this->products;
    }

    /**
     * @param Products $products
     *
     * @return Refund
     */
    public function setProducts(Products $products): self
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @param Product $product
     *
     * @return Refund
     */
    public function addProduct(Product $product): self
    {
        $this->getProducts()->addProduct($product);
        return $this;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return (string)$this->reason;
    }

    /**
     * @param string $reason
     *
     * @return Refund
     */
    public function setReason(string $reason): self
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getProcessDate(): DateTime
    {
        return $this->processDate;
    }

    /**
     * @param DateTime $processDate
     *
     * @return Refund
     */
    public function setProcessDate(DateTime $processDate): self
    {
        $this->processDate = $processDate;
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class BankAccount
 *
 * @package PayNL\Sdk\Model
 */
class BankAccount implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $bank;

    /**
     * @required
     *
     * @var string
     */
    protected $iban;

    /**
     * @var string
     */
    protected $bic;

    /**
     * @required
     *
     * @var string
     */
    protected $owner;

    /**
     * @var string
     */
    protected $returnUrl = '';

    /**
     * @return string
     */
    public function getBank(): string
    {
        return (string)$this->bank;
    }

    /**
     * @param string $bank
     *
     * @return BankAccount
     */
    public function setBank(string $bank): self
    {
        $this->bank = $bank;
        return $this;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return (string)$this->iban;
    }

    /**
     * @param string $iban
     *
     * @return BankAccount
     */
    public function setIban(string $iban): self
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @return string
     */
    public function getBic(): string
    {
        return (string)$this->bic;
    }

    /**
     * @param string $bic
     *
     * @return BankAccount
     */
    public function setBic(string $bic): self
    {
        $this->bic = $bic;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return (string)$this->owner;
    }

    /**
     * @param string $owner
     *
     * @return BankAccount
     */
    public function setOwner(string $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return (string)$this->returnUrl;
    }

    /**
     * @param string $returnUrl
     *
     * @return BankAccount
     */
    public function setReturnUrl(string $returnUrl): self
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }
}

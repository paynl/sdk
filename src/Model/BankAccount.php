<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use \JsonSerializable;

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
     * @var string
     */
    protected $iban;

    /**
     * @var string
     */
    protected $bic;

    /**
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
        return $this->bank;
    }

    /**
     * @param string $bank
     *
     * @return BankAccount
     */
    public function setBank(string $bank): BankAccount
    {
        $this->bank = $bank;
        return $this;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     *
     * @return BankAccount
     */
    public function setIban(string $iban): BankAccount
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @return string
     */
    public function getBic(): string
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     *
     * @return BankAccount
     */
    public function setBic(string $bic): BankAccount
    {
        $this->bic = $bic;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     *
     * @return BankAccount
     */
    public function setOwner(string $owner): BankAccount
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    /**
     * @param string $returnUrl
     *
     * @return BankAccount
     */
    public function setReturnUrl(string $returnUrl): BankAccount
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }
}

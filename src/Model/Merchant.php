<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use \DateTime;

/**
 * Class Merchant
 *
 * @package PayNL\Sdk\Model
 */
class Merchant implements ModelInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $coc;

    /**
     * @var string
     */
    protected $vat;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var BankAccount
     */
    protected $bankAccount;

    /**
     * @var Address
     */
    protected $postalAddress;

    /**
     * @var Address
     */
    protected $visitAddress;

    /**
     * @var array
     */
    protected $trademarks = [];

    /**
     * @var array
     */
    protected $contactMethods = [];

    /**
     * @var DateTime
     */
    protected $createdAt;

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
     * @return Merchant
     */
    public function setId(string $id): Merchant
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Merchant
     */
    public function setName(string $name): Merchant
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCoc(): string
    {
        return $this->coc;
    }

    /**
     * @param string $coc
     *
     * @return Merchant
     */
    public function setCoc(string $coc): Merchant
    {
        $this->coc = $coc;
        return $this;
    }

    /**
     * @return string
     */
    public function getVat(): string
    {
        return $this->vat;
    }

    /**
     * @param string $vat
     *
     * @return Merchant
     */
    public function setVat(string $vat): Merchant
    {
        $this->vat = $vat;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @param string $website
     *
     * @return Merchant
     */
    public function setWebsite(string $website): Merchant
    {
        $this->website = $website;
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
     * @return Merchant
     */
    public function setBankAccount(BankAccount $bankAccount): Merchant
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

    /**
     * @return Address
     */
    public function getPostalAddress(): Address
    {
        return $this->postalAddress;
    }

    /**
     * @param Address $postalAddress
     *
     * @return Merchant
     */
    public function setPostalAddress(Address $postalAddress): Merchant
    {
        $this->postalAddress = $postalAddress;
        return $this;
    }

    /**
     * @return Address
     */
    public function getVisitAddress(): Address
    {
        return $this->visitAddress;
    }

    /**
     * @param Address $visitAddress
     *
     * @return Merchant
     */
    public function setVisitAddress(Address $visitAddress): Merchant
    {
        $this->visitAddress = $visitAddress;
        return $this;
    }

    /**
     * @return array
     */
    public function getTrademarks(): array
    {
        return $this->trademarks;
    }

    /**
     * @param array $trademarks
     *
     * @return Merchant
     */
    public function setTrademarks(array $trademarks): Merchant
    {
        $this->trademarks = $trademarks;
        return $this;
    }

    /**
     * @return array
     */
    public function getContactMethods(): array
    {
        return $this->contactMethods;
    }

    /**
     * @param array $contactMethods
     *
     * @return Merchant
     */
    public function setContactMethods(array $contactMethods): Merchant
    {
        $this->contactMethods = $contactMethods;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return Merchant
     */
    public function setCreatedAt(DateTime $createdAt): Merchant
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}

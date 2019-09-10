<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use \DateTime;
use \JsonSerializable;

/**
 * Class Customer
 *
 * @package PayNL\Sdk\Model
 */
class Customer implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $initials;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var DateTime
     */
    protected $birthDate;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $trustLevel;

    /**
     * @var BankAccount
     */
    protected $bankAccount;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var string
     */
    protected $language;

    /**
     * @return string
     */
    public function getInitials(): string
    {
        return $this->initials;
    }

    /**
     * @param string $initials
     *
     * @return Customer
     */
    public function setInitials(string $initials): Customer
    {
        $this->initials = $initials;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Customer
     */
    public function setLastName(string $lastName): Customer
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime $birthDate
     *
     * @return Customer
     */
    public function setBirthDate(DateTime $birthDate): Customer
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return Customer
     */
    public function setGender(string $gender): Customer
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return Customer
     */
    public function setPhone(string $phone): Customer
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail(string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getTrustLevel(): string
    {
        return $this->trustLevel;
    }

    /**
     * @param string $trustLevel
     *
     * @return Customer
     */
    public function setTrustLevel(string $trustLevel): Customer
    {
        $this->trustLevel = $trustLevel;
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
     * @return Customer
     */
    public function setBankAccount(BankAccount $bankAccount): Customer
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return Customer
     */
    public function setReference(string $reference): Customer
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return Customer
     */
    public function setLanguage(string $language): Customer
    {
        $this->language = $language;
        return $this;
    }
}

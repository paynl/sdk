<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use DateTime,
    JsonSerializable;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Common\JsonSerializeTrait
};

/**
 * Class Customer
 *
 * @package PayNL\Sdk\Model
 */
class Customer implements
    ModelInterface,
    Member\BankAccountAwareInterface,
    JsonSerializable
{
    use Member\BankAccountAwareTrait;
    use JsonSerializeTrait;

    /*
     * Customer type constant definitions
     */
    public const TYPE_BUSINESS = 'B';
    public const TYPE_CONSUMER = 'C';

    /**
     * @var string
     */
    protected $type = self::TYPE_CONSUMER;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $ip;

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
     * @var int
     */
    protected $trustLevel = 0;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var Company
     */
    protected $company;

    /**
     * @return array
     */
    protected function getTypes(): array
    {
        return [
            static::TYPE_BUSINESS,
            static::TYPE_CONSUMER,
        ];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @throws InvalidArgumentException when given type is not allowed
     *
     * @return Customer
     */
    public function setType(string $type): self
    {
        $allowedTypes = $this->getTypes();
        if (false === in_array($type, $allowedTypes, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given type "%s" to %s is prohibited, choose one of "%s"',
                    $type,
                    __METHOD__,
                    implode('", "', $allowedTypes)
                )
            );
        }

        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     *
     * @return Customer
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return (string)$this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Customer
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return (string)$this->ip;
    }

    /**
     * @param string $ip
     *
     * @return Customer
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime $birthDate
     *
     * @return Customer
     */
    public function setBirthDate(DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return (string)$this->gender;
    }

    /**
     * @param string $gender
     *
     * @return Customer
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return (string)$this->phone;
    }

    /**
     * @param string $phone
     *
     * @return Customer
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return (string)$this->email;
    }

    /**
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getTrustLevel(): int
    {
        return $this->trustLevel;
    }

    /**
     * @param int $trustLevel
     *
     * @throws InvalidArgumentException
     *
     * @return Customer
     */
    public function setTrustLevel(int $trustLevel): self
    {
        // TODO: make it configurable by the config provider
        $min = -10;
        $max = 10;
        if (false === in_array($trustLevel, range($min, $max), true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given trust level "%d" to %s is not valid, choose one between %d and %d',
                    $trustLevel,
                    __METHOD__,
                    $min,
                    $max
                )
            );
        }

        $this->trustLevel = $trustLevel;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return (string)$this->reference;
    }

    /**
     * @param string $reference
     *
     * @return Customer
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        if (null === $this->company) {
            $this->setCompany(new Company());
        }
        return $this->company;
    }

    /**
     * @param Company $company
     *
     * @return Customer
     */
    public function setCompany(Company $company): self
    {
        $this->company = $company;
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\{
    Common\JsonSerializeTrait,
    Exception\InvalidArgumentException
};

/**
 * Class Address
 *
 * @package PayNL\Sdk\Model
 */
class Address implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $streetName;

    /**
     * @var string
     */
    protected $streetNumber;

    /**
     * @var string
     */
    protected $streetNumberExtension = '';

    /**
     * @var string
     */
    protected $zipCode;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $regionCode;

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return (string)$this->streetName;
    }

    /**
     * @param string $streetName
     *
     * @return Address
     */
    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreetNumber(): string
    {
        return (string)$this->streetNumber;
    }

    /**
     * @param string|int $streetNumber
     *
     * @throws InvalidArgumentException when the given argument is not a string nor an integer
     *
     * @return Address
     */
    public function setStreetNumber($streetNumber): self
    {
        $this->streetNumber = (string)$streetNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreetNumberExtension(): string
    {
        return $this->streetNumberExtension;
    }

    /**
     * @param string $streetNumberExtension
     *
     * @return Address
     */
    public function setStreetNumberExtension(string $streetNumberExtension): self
    {
        $this->streetNumberExtension = $streetNumberExtension;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return (string)$this->zipCode;
    }

    /**
     * @param string $zipCode
     *
     * @return Address
     */
    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return (string)$this->city;
    }

    /**
     * @param string $city
     *
     * @return Address
     */
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegionCode(): string
    {
        return (string)$this->regionCode;
    }

    /**
     * @param string $regionCode
     *
     * @return Address
     */
    public function setRegionCode(string $regionCode): self
    {
        $this->regionCode = $regionCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return (string)$this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return Address
     */
    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;
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
     * @return Address
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
     * @return Address
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }
}

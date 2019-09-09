<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Address
 *
 * @package PayNL\Sdk\Model
 */
class Address implements ModelInterface
{
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
    protected $streetNumberExtension;

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
    protected $initials;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return $this->streetName;
    }

    /**
     * @param string $streetName
     *
     * @return Address
     */
    public function setStreetName(string $streetName): Address
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    /**
     * @param string $streetNumber
     *
     * @return Address
     */
    public function setStreetNumber(string $streetNumber): Address
    {
        $this->streetNumber = $streetNumber;
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
    public function setStreetNumberExtension(string $streetNumberExtension): Address
    {
        $this->streetNumberExtension = $streetNumberExtension;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     *
     * @return Address
     */
    public function setZipCode(string $zipCode): Address
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Address
     */
    public function setCity(string $city): Address
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegionCode(): string
    {
        return $this->regionCode;
    }

    /**
     * @param string $regionCode
     *
     * @return Address
     */
    public function setRegionCode(string $regionCode): Address
    {
        $this->regionCode = $regionCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return Address
     */
    public function setCountryCode(string $countryCode): Address
    {
        $this->countryCode = $countryCode;
        return $this;
    }

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
     * @return Address
     */
    public function setInitials(string $initials): Address
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
     * @return Address
     */
    public function setLastName(string $lastName): Address
    {
        $this->lastName = $lastName;
        return $this;
    }
}

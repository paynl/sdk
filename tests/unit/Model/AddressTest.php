<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Model\{
    ModelInterface,
    Address
};
use TypeError, JsonSerializable;

/**
 * Class AddressTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class AddressTest extends UnitTest
{
    /**
     * @var Address
     */
    protected $address;

    public function _before(): void
    {
        $this->address = new Address();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->address)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->address)->isInstanceOf(JsonSerializable::class);

        verify($this->address->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAStreetName(): void
    {
        expect($this->address->setStreetName('Jan Campertlaan'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetAStreetName
     *
     * @return void
     */
    public function testItCanGetAStreetName(): void
    {
        $this->address->setStreetName('Jan Campertlaan');

        verify($this->address->getStreetName())->string();
        verify($this->address->getStreetName())->notEmpty();
        verify($this->address->getStreetName())->equals('Jan Campertlaan');
    }

    /**
     * @return void
     */
    public function testItCanSetAStreetNumber(): void
    {
        expect($this->address->setStreetNumber('10'))->isInstanceOf(Address::class);
        expect($this->address->setStreetNumber(10))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetAStreetNumber
     *
     * @return void
     */
    public function testItCanGetAStreetNumber(): void
    {
        $this->address->setStreetNumber('10');

        verify($this->address->getStreetNumber())->string();
        verify($this->address->getStreetNumber())->notEmpty();
        verify($this->address->getStreetNumber())->equals('10');

        $this->address->setStreetNumber(10);

        verify($this->address->getStreetNumber())->string();
        verify($this->address->getStreetNumber())->notEmpty();
        verify($this->address->getStreetNumber())->equals('10');
    }

    /**
     * @return void
     */
    public function testItCanSetAStreetNumberExtension(): void
    {
        expect($this->address->setStreetNumberExtension('a'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetAStreetNumberExtension
     *
     * @return void
     */
    public function testItCanGetAStreetNumberExtension(): void
    {
        verify($this->address->getStreetNumberExtension())->isEmpty();

        $this->address->setStreetNumberExtension('a');

        verify($this->address->getStreetNumberExtension())->string();
        verify($this->address->getStreetNumberExtension())->notEmpty();
        verify($this->address->getStreetNumberExtension())->equals('a');
    }

    /**
     * @return void
     */
    public function testItCanSetAZipCode(): void
    {
        expect($this->address->setZipCode('3201 AX'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetAZipCode
     *
     * @return void
     */
    public function testItCanGetAZipCode(): void
    {
        $this->address->setZipCode('3201 AX');

        verify($this->address->getZipCode())->string();
        verify($this->address->getZipCode())->notEmpty();
        verify($this->address->getZipCode())->equals('3201 AX');
    }

    /**
     * @return void
     */
    public function testItCanSetACity(): void
    {
        expect($this->address->setCity('Spijkenisse'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetACity
     *
     * @return void
     */
    public function testItCanGetACity(): void
    {
        $this->address->setCity('Spijkenisse');

        verify($this->address->getCity())->string();
        verify($this->address->getCity())->notEmpty();
        verify($this->address->getCity())->equals('Spijkenisse');
    }

    /**
     * @return void
     */
    public function testItCanSetARegionCode(): void
    {
        expect($this->address->setRegionCode('ZH'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetARegionCode
     *
     * @return void
     */
    public function testItCanGetARegionCode(): void
    {
        $this->address->setRegionCode('ZH');

        verify($this->address->getRegionCode())->string();
        verify($this->address->getRegionCode())->notEmpty();
        verify($this->address->getRegionCode())->equals('ZH');
    }

    /**
     * @return void
     */
    public function testItCanSetACountryCode(): void
    {
        expect($this->address->setCountryCode('NL'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetACountryCode
     *
     * @return void
     */
    public function testItCanGetACountryCode(): void
    {
        $this->address->setCountryCode('NL');

        verify($this->address->getCountryCode())->string();
        verify($this->address->getCountryCode())->notEmpty();
        verify($this->address->getCountryCode())->equals('NL');
    }

    /**
     * @return void
     */
    public function testItCanSetName(): void
    {
        expect($this->address->setName('O'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetName
     *
     * @return void
     */
    public function testItCanGetName(): void
    {
        $this->address->setName('O');

        verify($this->address->getName())->string();
        verify($this->address->getName())->notEmpty();
        verify($this->address->getName())->equals('O');
    }

    /**
     * @return void
     */
    public function testItCanSetALastName(): void
    {
        expect($this->address->setLastName('Kenobi'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetALastName
     *
     * @return void
     */
    public function testItCanGetALastName(): void
    {
        $this->address->setLastName('Kenobi');

        verify($this->address->getLastName())->string();
        verify($this->address->getLastName())->notEmpty();
        verify($this->address->getLastName())->equals('Kenobi');
    }
}

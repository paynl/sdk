<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Address;

/**
 * Class AddressTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class AddressTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Address
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->shouldItBeJsonSerializable = true;
        $this->model = new Address();
    }

    /**
     * @return void
     */
    public function testItCanSetAStreetName(): void
    {
        $this->tester->assertObjectHasMethod('setStreetName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStreetName', $this->model);

        expect($this->model->setStreetName('Jan Campertlaan'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetAStreetName
     *
     * @return void
     */
    public function testItCanGetAStreetName(): void
    {
        $this->tester->assertObjectHasMethod('getStreetName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getStreetName', $this->model);

        $this->model->setStreetName('Jan Campertlaan');

        verify($this->model->getStreetName())->string();
        verify($this->model->getStreetName())->notEmpty();
        verify($this->model->getStreetName())->equals('Jan Campertlaan');
    }

    /**
     * @return void
     */
    public function testItCanSetAStreetNumber(): void
    {
        $this->tester->assertObjectHasMethod('setStreetNumber', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStreetNumber', $this->model);

        expect($this->model->setStreetNumber('10'))->isInstanceOf(Address::class);
        expect($this->model->setStreetNumber(10))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetAStreetNumber
     *
     * @return void
     */
    public function testItCanGetAStreetNumber(): void
    {
        $this->tester->assertObjectHasMethod('getStreetNumber', $this->model);
        $this->tester->assertObjectMethodIsPublic('getStreetNumber', $this->model);

        $this->model->setStreetNumber('10');

        verify($this->model->getStreetNumber())->string();
        verify($this->model->getStreetNumber())->notEmpty();
        verify($this->model->getStreetNumber())->equals('10');

        $this->model->setStreetNumber(10);

        verify($this->model->getStreetNumber())->string();
        verify($this->model->getStreetNumber())->notEmpty();
        verify($this->model->getStreetNumber())->equals('10');
    }

    /**
     * @return void
     */
    public function testItCanSetAStreetNumberExtension(): void
    {
        $this->tester->assertObjectHasMethod('setStreetNumberExtension', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStreetNumberExtension', $this->model);

        expect($this->model->setStreetNumberExtension('a'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetAStreetNumberExtension
     *
     * @return void
     */
    public function testItCanGetAStreetNumberExtension(): void
    {
        $this->tester->assertObjectHasMethod('getStreetNumberExtension', $this->model);
        $this->tester->assertObjectMethodIsPublic('getStreetNumberExtension', $this->model);

        verify($this->model->getStreetNumberExtension())->isEmpty();

        $this->model->setStreetNumberExtension('a');

        verify($this->model->getStreetNumberExtension())->string();
        verify($this->model->getStreetNumberExtension())->notEmpty();
        verify($this->model->getStreetNumberExtension())->equals('a');
    }

    /**
     * @return void
     */
    public function testItCanSetAZipCode(): void
    {
        $this->tester->assertObjectHasMethod('setZipCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setZipCode', $this->model);

        expect($this->model->setZipCode('3201 AX'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetAZipCode
     *
     * @return void
     */
    public function testItCanGetAZipCode(): void
    {
        $this->tester->assertObjectHasMethod('getZipCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getZipCode', $this->model);

        $this->model->setZipCode('3201 AX');

        verify($this->model->getZipCode())->string();
        verify($this->model->getZipCode())->notEmpty();
        verify($this->model->getZipCode())->equals('3201 AX');
    }

    /**
     * @return void
     */
    public function testItCanSetACity(): void
    {
        $this->tester->assertObjectHasMethod('setCity', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCity', $this->model);

        expect($this->model->setCity('Spijkenisse'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetACity
     *
     * @return void
     */
    public function testItCanGetACity(): void
    {
        $this->tester->assertObjectHasMethod('getCity', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCity', $this->model);

        $this->model->setCity('Spijkenisse');

        verify($this->model->getCity())->string();
        verify($this->model->getCity())->notEmpty();
        verify($this->model->getCity())->equals('Spijkenisse');
    }

    /**
     * @return void
     */
    public function testItCanSetARegionCode(): void
    {
        $this->tester->assertObjectHasMethod('setRegionCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setRegionCode', $this->model);

        expect($this->model->setRegionCode('ZH'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetARegionCode
     *
     * @return void
     */
    public function testItCanGetARegionCode(): void
    {
        $this->tester->assertObjectHasMethod('getRegionCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getRegionCode', $this->model);

        $this->model->setRegionCode('ZH');

        verify($this->model->getRegionCode())->string();
        verify($this->model->getRegionCode())->notEmpty();
        verify($this->model->getRegionCode())->equals('ZH');
    }

    /**
     * @return void
     */
    public function testItCanSetACountryCode(): void
    {
        $this->tester->assertObjectHasMethod('setCountryCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCountryCode', $this->model);

        expect($this->model->setCountryCode('NL'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetACountryCode
     *
     * @return void
     */
    public function testItCanGetACountryCode(): void
    {
        $this->tester->assertObjectHasMethod('getCountryCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCountryCode', $this->model);

        $this->model->setCountryCode('NL');

        verify($this->model->getCountryCode())->string();
        verify($this->model->getCountryCode())->notEmpty();
        verify($this->model->getCountryCode())->equals('NL');
    }

    /**
     * @return void
     */
    public function testItCanSetName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('O'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetName
     *
     * @return void
     */
    public function testItCanGetName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getName', $this->model);

        $this->model->setName('O');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('O');
    }

    /**
     * @return void
     */
    public function testItCanSetALastName(): void
    {
        $this->tester->assertObjectHasMethod('setLastName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setLastName', $this->model);

        expect($this->model->setLastName('Kenobi'))->isInstanceOf(Address::class);
    }

    /**
     * @depends testItCanSetALastName
     *
     * @return void
     */
    public function testItCanGetALastName(): void
    {
        $this->tester->assertObjectHasMethod('getLastName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getLastName', $this->model);

        $this->model->setLastName('Kenobi');

        verify($this->model->getLastName())->string();
        verify($this->model->getLastName())->notEmpty();
        verify($this->model->getLastName())->equals('Kenobi');
    }
}

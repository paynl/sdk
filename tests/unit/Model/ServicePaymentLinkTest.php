<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{Amount, ModelInterface, ServicePaymentLink, Statistics};
use PayNL\Sdk\DateTime;
use Exception, JsonSerializable;

/**
 * Class ServicePaymentLinkTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ServicePaymentLinkTest extends UnitTest
{
    /**
     * @var ServicePaymentLink
     */
    protected $servicePaymentLink;

    public function _before(): void
    {
        $this->servicePaymentLink = new ServicePaymentLink();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->servicePaymentLink)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->servicePaymentLink)->isInstanceOf(JsonSerializable::class);

        verify($this->servicePaymentLink->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetSecurityMode(): void
    {
        expect($this->servicePaymentLink->setSecurityMode(1))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetSecurityMode
     *
     * @return void
     */
    public function testItCanGetSecurityMode(): void
    {
        $this->servicePaymentLink->setSecurityMode(1);

        verify($this->servicePaymentLink->getSecurityMode())->int();
        verify($this->servicePaymentLink->getSecurityMode())->notEmpty();
        verify($this->servicePaymentLink->getSecurityMode())->equals(1);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->servicePaymentLink->setAmount(new Amount()))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->servicePaymentLink->setAmount(new Amount());

        verify($this->servicePaymentLink->getAmount())->notEmpty();
        verify($this->servicePaymentLink->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmountMin(): void
    {
        expect($this->servicePaymentLink->setAmountMin(new Amount()))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetAnAmountMin
     *
     * @return void
     */
    public function testItCanGetAnAmountMin(): void
    {
        $this->servicePaymentLink->setAmountMin(new Amount());

        verify($this->servicePaymentLink->getAmountMin())->notEmpty();
        verify($this->servicePaymentLink->getAmountMin())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetACountryCode(): void
    {
        expect($this->servicePaymentLink->setCountryCode('NL'))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetACountryCode
     *
     * @return void
     */
    public function testItCanGetACountryCode(): void
    {
        $this->servicePaymentLink->setCountryCode('NL');

        verify($this->servicePaymentLink->getCountryCode())->string();
        verify($this->servicePaymentLink->getCountryCode())->notEmpty();
        verify($this->servicePaymentLink->getCountryCode())->equals('NL');
    }

    /**
     * @return void
     */
    public function testItCanSetALanguage(): void
    {
        expect($this->servicePaymentLink->setLanguage('nl'))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetALanguage
     *
     * @return void
     */
    public function testItCanGetALanguage(): void
    {
        $this->servicePaymentLink->setLanguage('nl');

        verify($this->servicePaymentLink->getLanguage())->string();
        verify($this->servicePaymentLink->getLanguage())->notEmpty();
        verify($this->servicePaymentLink->getLanguage())->equals('nl');
    }

    /**
     * @return void
     */
    public function testItCanSetStatistics(): void
    {
        expect($this->servicePaymentLink->setStatistics(new Statistics()))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetStatistics
     *
     * @return void
     */
    public function testItCanGetStatistics(): void
    {
        $this->servicePaymentLink->setStatistics(new Statistics());

        verify($this->servicePaymentLink->getStatistics())->notEmpty();
        verify($this->servicePaymentLink->getStatistics())->isInstanceOf(Statistics::class);
    }
}

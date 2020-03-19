<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{Amount, ModelInterface, ServicePaymentLink, Statistics};
use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;
use PayNL\Sdk\Exception\InvalidArgumentException;
use UnitTester;

/**
 * Class ServicePaymentLinkTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ServicePaymentLinkTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

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
    }

    /**
     * @return void
     */
    public function testItUsesJsonSerializeTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->servicePaymentLink), true))->true();
    }

    /**
     * @return array
     */
    private function getAvailableSecurityModes(): array
    {
        return $this->tester->invokeMethod($this->servicePaymentLink, 'getSecurityModes');
    }

    /**
     * @return void
     */
    public function testItHasAvailableSecurityModes(): void
    {
        verify(method_exists($this->servicePaymentLink, 'getSecurityModes'))->true();
    }

    /**
     * @depends testItHasAvailableSecurityModes
     *
     * @return void
     */
    public function testItCanSetSecurityMode(): void
    {
        $securityMode = ($this->getAvailableSecurityModes())[0];
        verify($this->servicePaymentLink->setSecurityMode($securityMode))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenSettingUnavailableSecurityMode(): void
    {
        $securityMode = -1;
        verify(in_array($securityMode, $this->getAvailableSecurityModes(), true))->false();
        $this->expectException(InvalidArgumentException::class);
        $this->servicePaymentLink->setSecurityMode($securityMode);
    }

    /**
     * depends testItCanSetSecurityMode
     *
     * @return void
     */
    public function testItCanGetSecurityMode(): void
    {
        $securityMode = ($this->getAvailableSecurityModes())[0];
        $this->servicePaymentLink->setSecurityMode($securityMode);

        verify($this->servicePaymentLink->getSecurityMode())->int();
        verify($this->servicePaymentLink->getSecurityMode())->equals($securityMode);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        expect($this->servicePaymentLink->setAmount($amountMock))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        /** @var Amount $amountMock */
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        $amountMock->setAmount(12345);
        $this->servicePaymentLink->setAmount($amountMock);

        verify($this->servicePaymentLink->getAmount())->notEmpty();
        verify($this->servicePaymentLink->getAmount())->isInstanceOf(Amount::class);
        verify($this->servicePaymentLink->getAmount())->equals($amountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmountMin(): void
    {
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        expect($this->servicePaymentLink->setAmountMin($amountMock))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetAnAmountMin
     *
     * @return void
     */
    public function testItCanGetAnAmountMin(): void
    {
        /** @var Amount $amountMock */
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        $amountMock->setAmount(12345);
        $this->servicePaymentLink->setAmountMin($amountMock);

        verify($this->servicePaymentLink->getAmountMin())->notEmpty();
        verify($this->servicePaymentLink->getAmountMin())->isInstanceOf(Amount::class);
        verify($this->servicePaymentLink->getAmountMin())->equals($amountMock);
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
        $statisticsMock = $this->tester->grabService('modelManager')->get('Statistics');
        expect($this->servicePaymentLink->setStatistics($statisticsMock))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetStatistics
     *
     * @return void
     */
    public function testItCanGetStatistics(): void
    {
        /** @var Statistics $statisticsMock */
        $statisticsMock = $this->tester->grabService('modelManager')->get('Statistics');
        $statisticsMock->setInfo('12345');
        $this->servicePaymentLink->setStatistics($statisticsMock);

        verify($this->servicePaymentLink->getStatistics())->notEmpty();
        verify($this->servicePaymentLink->getStatistics())->isInstanceOf(Statistics::class);
        verify($this->servicePaymentLink->getStatistics())->equals($statisticsMock);
    }
}

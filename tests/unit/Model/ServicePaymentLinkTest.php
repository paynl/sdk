<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
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
    use ModelTestTrait;

    /**
     * @var ServicePaymentLink
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new ServicePaymentLink();
    }

    /**
     * @return array
     */
    private function getAvailableSecurityModes(): array
    {
        return $this->tester->invokeMethod($this->model, 'getSecurityModes');
    }

    /**
     * @return void
     */
    public function testItHasAvailableSecurityModes(): void
    {
        verify(method_exists($this->model, 'getSecurityModes'))->true();
    }

    /**
     * @depends testItHasAvailableSecurityModes
     *
     * @return void
     */
    public function testItCanSetSecurityMode(): void
    {
        $securityMode = ($this->getAvailableSecurityModes())[0];
        verify($this->model->setSecurityMode($securityMode))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenSettingUnavailableSecurityMode(): void
    {
        $securityMode = -1;
        verify(in_array($securityMode, $this->getAvailableSecurityModes(), true))->false();
        $this->expectException(InvalidArgumentException::class);
        $this->model->setSecurityMode($securityMode);
    }

    /**
     * depends testItCanSetSecurityMode
     *
     * @return void
     */
    public function testItCanGetSecurityMode(): void
    {
        $securityMode = ($this->getAvailableSecurityModes())[0];
        $this->model->setSecurityMode($securityMode);

        verify($this->model->getSecurityMode())->int();
        verify($this->model->getSecurityMode())->equals($securityMode);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        expect($this->model->setAmount($amountMock))->isInstanceOf(ServicePaymentLink::class);
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
        $this->model->setAmount($amountMock);

        verify($this->model->getAmount())->notEmpty();
        verify($this->model->getAmount())->isInstanceOf(Amount::class);
        verify($this->model->getAmount())->equals($amountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmountMin(): void
    {
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        expect($this->model->setAmountMin($amountMock))->isInstanceOf(ServicePaymentLink::class);
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
        $this->model->setAmountMin($amountMock);

        verify($this->model->getAmountMin())->notEmpty();
        verify($this->model->getAmountMin())->isInstanceOf(Amount::class);
        verify($this->model->getAmountMin())->equals($amountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetACountryCode(): void
    {
        expect($this->model->setCountryCode('NL'))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetACountryCode
     *
     * @return void
     */
    public function testItCanGetACountryCode(): void
    {
        $this->model->setCountryCode('NL');

        verify($this->model->getCountryCode())->string();
        verify($this->model->getCountryCode())->notEmpty();
        verify($this->model->getCountryCode())->equals('NL');
    }

    /**
     * @return void
     */
    public function testItCanSetALanguage(): void
    {
        expect($this->model->setLanguage('nl'))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanSetALanguage
     *
     * @return void
     */
    public function testItCanGetALanguage(): void
    {
        $this->model->setLanguage('nl');

        verify($this->model->getLanguage())->string();
        verify($this->model->getLanguage())->notEmpty();
        verify($this->model->getLanguage())->equals('nl');
    }

    /**
     * @return void
     */
    public function testItCanSetStatistics(): void
    {
        $statisticsMock = $this->tester->grabService('modelManager')->get('Statistics');
        expect($this->model->setStatistics($statisticsMock))->isInstanceOf(ServicePaymentLink::class);
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
        $this->model->setStatistics($statisticsMock);

        verify($this->model->getStatistics())->notEmpty();
        verify($this->model->getStatistics())->isInstanceOf(Statistics::class);
        verify($this->model->getStatistics())->equals($statisticsMock);
    }

    /**
     *
     */
    public function testItCanGetUrl(): void
    {
        verify($this->model->setUrl('https://www.pay.nl'))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @depends testItCanGetUrl
     */
    public function testItCanSetUrl(): void
    {
        $url = 'https://www.pay.nl';
        $this->model->setUrl($url);
        verify($this->model->getUrl())->equals($url);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Common\DateTime,
    Model\Amount,
    Model\Customer,
    Model\Interval,
    Model\Mandate,
    Model\Statistics
};
use Mockery;

/**
 * Class MandateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class MandateTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Mandate
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Mandate();
    }

    /**
     * @return void
     */
    public function testItCanSetId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        $mandate = $this->model->setId('foo');
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetId
     *
     * @return void
     */
    public function testItCanGetId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $id = $this->model->getId();
        verify($id)->string();
        verify($id)->isEmpty();

        $this->model->setId('foo');
        $id = $this->model->getId();
        verify($id)->string();
        verify($id)->notEmpty();
        verify($id)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetType(): void
    {
        $this->tester->assertObjectHasMethod('setType', $this->model);
        $this->tester->assertObjectMethodIsPublic('setType', $this->model);

        $mandate = $this->model->setType('foo');
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetType
     *
     * @return void
     */
    public function testItCanGetType(): void
    {
        $this->tester->assertObjectHasMethod('getType', $this->model);
        $this->tester->assertObjectMethodIsPublic('getType', $this->model);

        $type = $this->model->getType();
        verify($type)->string();
        verify($type)->isEmpty();

        $this->model->setType('foo');
        $type = $this->model->getType();
        verify($type)->string();
        verify($type)->notEmpty();
        verify($type)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetServiceId(): void
    {
        $this->tester->assertObjectHasMethod('setServiceId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setServiceId', $this->model);

        $mandate = $this->model->setServiceId('foo');
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetServiceId
     *
     * @return void
     */
    public function testItCanGetServiceId(): void
    {
        $this->tester->assertObjectHasMethod('getServiceId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getServiceId', $this->model);

        $serviceId = $this->model->getServiceId();
        verify($serviceId)->string();
        verify($serviceId)->isEmpty();

        $this->model->setServiceId('foo');
        $serviceId = $this->model->getServiceId();
        verify($serviceId)->string();
        verify($serviceId)->notEmpty();
        verify($serviceId)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetProcessDate(): void
    {
        $this->tester->assertObjectHasMethod('setProcessDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('setProcessDate', $this->model);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $mandate = $this->model->setProcessDate($dateTimeMock);
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetProcessDate
     *
     * @return void
     */
    public function testItCanGetProcessDate(): void
    {
        $this->tester->assertObjectHasMethod('getProcessDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('getProcessDate', $this->model);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $this->model->setProcessDate($dateTimeMock);
        $processDate = $this->model->getProcessDate();
        verify($processDate)->notEmpty();
        verify($processDate)->isInstanceOf(DateTime::class);
        verify($processDate)->same($dateTimeMock);
    }

    /**
     * @return void
     */
    public function testItCanSetExchangeUrl(): void
    {
        $this->tester->assertObjectHasMethod('setExchangeUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExchangeUrl', $this->model);

        $mandate = $this->model->setExchangeUrl('http://foo.bar');
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetExchangeUrl
     *
     * @return void
     */
    public function testItCanGetExchangeUrl(): void
    {
        $this->tester->assertObjectHasMethod('getExchangeUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExchangeUrl', $this->model);

        $exchangeUrl = $this->model->getExchangeUrl();
        verify($exchangeUrl)->string();
        verify($exchangeUrl)->isEmpty();

        $this->model->setExchangeUrl('http://foo.bar');
        $exchangeUrl = $this->model->getExchangeUrl();
        verify($exchangeUrl)->string();
        verify($exchangeUrl)->notEmpty();
        verify($exchangeUrl)->equals('http://foo.bar');
    }

    /**
     * @return void
     */
    public function testItCanSetAmount(): void
    {
        $this->tester->assertObjectHasMethod('setAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmount', $this->model);

        $mockAmount = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $mandate = $this->model->setAmount($mockAmount);
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetAmount
     *
     * @return void
     */
    public function testItCanGetAmount(): void
    {
        $this->tester->assertObjectHasMethod('getAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmount', $this->model);

        $mockAmount = $this->tester->grabMockService('modelManager')->get(Amount::class);
        $this->model->setAmount($mockAmount);
        $amount = $this->model->getAmount();
        verify($amount)->notEmpty();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount)->same($mockAmount);
    }

    /**
     * @return void
     */
    public function testItCanSetDescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        $mandate = $this->model->setDescription('foo');
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetDescription
     *
     * @return void
     */
    public function testItCanGetDescription(): void
    {
        $this->tester->assertObjectHasMethod('getDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDescription', $this->model);

        $description = $this->model->getDescription();
        verify($description)->string();
        verify($description)->isEmpty();

        $this->model->setDescription('foo');
        $description = $this->model->getDescription();
        verify($description)->string();
        verify($description)->notEmpty();
        verify($description)->equals('foo');
    }

    /**
     * @return void
     */
    public function testItCanSetStatistics(): void
    {
        $this->tester->assertObjectHasMethod('setStatistics', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStatistics', $this->model);

        $mockStatistics = $this->tester->grabMockService('modelManager')->get(Statistics::class);
        $mandate = $this->model->setStatistics($mockStatistics);
        verify($mandate)->object();
        verify($mandate)->same($this->model);
        expect($this->model->setStatistics(new Statistics()))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetStatistics
     *
     * @return void
     */
    public function testItCanGetStatistics(): void
    {
        $this->tester->assertObjectHasMethod('getStatistics', $this->model);
        $this->tester->assertObjectMethodIsPublic('getStatistics', $this->model);

        $mockStatistics = $this->tester->grabMockService('modelManager')->get(Statistics::class);
        $this->model->setStatistics($mockStatistics);
        $statistics = $this->model->getStatistics();
        verify($statistics)->notEmpty();
        verify($statistics)->isInstanceOf(Statistics::class);
        verify($statistics)->same($mockStatistics);
    }

    /**
     * @return void
     */
    public function testItCanSetInterval(): void
    {
        $this->tester->assertObjectHasMethod('setInterval', $this->model);
        $this->tester->assertObjectMethodIsPublic('setInterval', $this->model);

        $mockInterval = $this->tester->grabMockService('modelManager')->get(Interval::class);
        $mandate = $this->model->setInterval($mockInterval);
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetInterval
     *
     * @return void
     */
    public function testItCanGetInterval(): void
    {
        $this->tester->assertObjectHasMethod('getInterval', $this->model);
        $this->tester->assertObjectMethodIsPublic('getInterval', $this->model);

        verify($this->model->getInterval())->isInstanceOf(Interval::class);

        $mockInterval = $this->tester->grabMockService('modelManager')->get(Interval::class);
        $this->model->setInterval($mockInterval);
        $interval = $this->model->getInterval();
        verify($interval)->notEmpty();
        verify($interval)->isInstanceOf(Interval::class);
        verify($interval)->same($mockInterval);
    }

    /**
     * @return void
     */
    public function testItCanSetCustomer(): void
    {
        $this->tester->assertObjectHasMethod('setCustomer', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCustomer', $this->model);

        $mockCustomer = $this->tester->grabMockService('modelManager')->get(Customer::class);
        $mandate = $this->model->setCustomer($mockCustomer);
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetCustomer
     *
     * @return void
     */
    public function testItCanGetCustomer(): void
    {
        $this->tester->assertObjectHasMethod('getCustomer', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCustomer', $this->model);

        $customer = $this->model->getCustomer();
        verify($customer)->isInstanceOf(Customer::class);

        $mockCustomer = $this->tester->grabMockService('modelManager')->get(Customer::class);
        $this->model->setCustomer($mockCustomer);
        $customer = $this->model->getCustomer();
        verify($customer)->notEmpty();
        verify($customer)->isInstanceOf(Customer::class);
        verify($customer)->same($mockCustomer);
    }

    /**
     * @return void
     */
    public function testItCanBeMarkedAsLastOrder(): void
    {
        $this->tester->assertObjectHasMethod('setIsLastOrder', $this->model);
        $this->tester->assertObjectMethodIsPublic('setIsLastOrder', $this->model);

        $mandate = $this->model->setIsLastOrder(true);
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanBeMarkedAsLastOrder
     *
     * @return void
     */
    public function testItCheckIsLastOrder(): void
    {
        $this->tester->assertObjectHasMethod('isLastOrder', $this->model);
        $this->tester->assertObjectMethodIsPublic('isLastOrder', $this->model);

        $isLastOrder = $this->model->isLastOrder();
        verify($isLastOrder)->bool();
        verify($isLastOrder)->false();

        $this->model->setIsLastOrder(true);
        $isLastOrder = $this->model->isLastOrder();
        verify($isLastOrder)->bool();
        verify($isLastOrder)->true();
    }

    /**
     * @return void
     */
    public function testItCanSetState(): void
    {
        $this->tester->assertObjectHasMethod('setState', $this->model);
        $this->tester->assertObjectMethodIsPublic('setState', $this->model);

        $mandate = $this->model->setState('foo');
        verify($mandate)->object();
        verify($mandate)->same($this->model);
    }

    /**
     * @depends testItCanSetState
     *
     * @return void
     */
    public function testItCanGetState(): void
    {
        $this->tester->assertObjectHasMethod('getState', $this->model);
        $this->tester->assertObjectMethodIsPublic('getState', $this->model);

        $state = $this->model->getState();
        verify($state)->string();
        verify($state)->isEmpty();

        $this->model->setState('foo');
        $state = $this->model->getState();
        verify($state)->string();
        verify($state)->notEmpty();
        verify($state)->equals('foo');
    }
}

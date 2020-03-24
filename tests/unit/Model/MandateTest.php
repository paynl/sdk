<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Amount,
    BankAccount,
    Customer,
    Interval,
    Mandate,
    Statistics
};
use JsonSerializable, Exception;
use PayNL\Sdk\Common\JsonSerializeTrait;
use PayNL\Sdk\Common\DateTime;

/**
 * Class MandateTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class MandateTest extends UnitTest
{
    /**
     * @var Mandate
     */
    protected $mandate;

    public function _before(): void
    {
        $this->mandate = new Mandate();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->mandate)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->mandate)->isInstanceOf(JsonSerializable::class);
    }

    public function testItIsUsingJsonSerializeTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->mandate), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        verify($this->mandate->setId('IO-1000-0000-0001'))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->mandate->setId('IO-1000-0000-0001');

        verify($this->mandate->getId())->string();
        verify($this->mandate->getId())->notEmpty();
        verify($this->mandate->getId())->equals('IO-1000-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetAType(): void
    {
        expect($this->mandate->setType('single'))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetAType
     *
     * @return void
     */
    public function testItCanGetAType(): void
    {
        $this->mandate->setType('single');

        verify($this->mandate->getType())->string();
        verify($this->mandate->getType())->notEmpty();
        verify($this->mandate->getType())->equals('single');
    }

    /**
     * @return void
     */
    public function testItCanSetAServiceId(): void
    {
        expect($this->mandate->setServiceId('SL-1000-0000-0001'))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetAServiceId
     *
     * @return void
     */
    public function testItCanGetAServiceId(): void
    {
        $this->mandate->setServiceId('SL-1000-0000-0001');

        verify($this->mandate->getServiceId())->string();
        verify($this->mandate->getServiceId())->notEmpty();
        verify($this->mandate->getServiceId())->equals('SL-1000-0000-0001');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAProcessDate(): void
    {
        expect($this->mandate->setProcessDate(new DateTime()))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetAProcessDate
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAProcessDate(): void
    {
        $this->mandate->setProcessDate(new DateTime());

        verify($this->mandate->getProcessDate())->notEmpty();
        verify($this->mandate->getProcessDate())->isInstanceOf(DateTime::class);
    }



    /**
     * @return void
     */
    public function testItCanSetAnExchangeUrl(): void
    {
        expect($this->mandate->setExchangeUrl('https://www.pay.nl/exchange-url'))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetAnExchangeUrl
     *
     * @return void
     */
    public function testItCanGetAnExchangeUrl(): void
    {
        $this->mandate->setExchangeUrl('https://www.pay.nl/exchange-url');

        verify($this->mandate->getExchangeUrl())->string();
        verify($this->mandate->getExchangeUrl())->notEmpty();
        verify($this->mandate->getExchangeUrl())->equals('https://www.pay.nl/exchange-url');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->mandate->setAmount(new Amount()))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->mandate->setAmount(new Amount());

        verify($this->mandate->getAmount())->notEmpty();
        verify($this->mandate->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->mandate->setDescription('test'))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->mandate->setDescription('test');

        verify($this->mandate->getDescription())->string();
        verify($this->mandate->getDescription())->notEmpty();
        verify($this->mandate->getDescription())->equals('test');
    }

    /**
     * @return void
     */
    public function testItCanSetStatistics(): void
    {
        expect($this->mandate->setStatistics(new Statistics()))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetStatistics
     *
     * @return void
     */
    public function testItCanGetStatistics(): void
    {
        $this->mandate->setStatistics(new Statistics());

        verify($this->mandate->getStatistics())->notEmpty();
        verify($this->mandate->getStatistics())->isInstanceOf(Statistics::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnInterval(): void
    {
        expect($this->mandate->setInterval(new Interval()))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetAnInterval
     *
     * @return void
     */
    public function testItCanGetAnInterval(): void
    {
        $this->mandate->setInterval(new Interval());

        verify($this->mandate->getInterval())->notEmpty();
        verify($this->mandate->getInterval())->isInstanceOf(Interval::class);
    }

    /**
     * @return void
     */
    public function testItCanSetACustomer(): void
    {
        expect($this->mandate->setCustomer(new Customer()))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetACustomer
     *
     * @return void
     */
    public function testItCanGetACustomer(): void
    {
        $this->mandate->setCustomer(new Customer());

        verify($this->mandate->getCustomer())->notEmpty();
        verify($this->mandate->getCustomer())->isInstanceOf(Customer::class);
    }

    /**
     * @return void
     */
    public function testItCanBeMarkedAsLastOrder(): void
    {
        expect($this->mandate->setIsLastOrder(true))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanBeMarkedAsLastOrder
     *
     * @return void
     */
    public function testItCheckIsLastOrder(): void
    {
        $this->mandate->setIsLastOrder(true);

        verify($this->mandate->isLastOrder())->bool();
        verify($this->mandate->isLastOrder())->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAState(): void
    {
        verify(method_exists($this->mandate, 'setState'))->true();
        verify($this->mandate->setState('single'))->isInstanceOf(Mandate::class);
    }

    /**
     * @depends testItCanSetAState
     *
     * @return void
     */
    public function testItCanGetAState(): void
    {
        verify(method_exists($this->mandate, 'getState'))->true();

        $this->mandate->setState('single');

        verify($this->mandate->getState())->string();
        verify($this->mandate->getState())->notEmpty();
        verify($this->mandate->getState())->equals('single');
    }
}

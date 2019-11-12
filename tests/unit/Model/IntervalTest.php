<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Interval
};
use JsonSerializable;

/**
 * Class IntervalTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class IntervalTest extends UnitTest
{
    /**
     * @var Interval
     */
    protected $interval;

    public function _before(): void
    {
        $this->interval = new Interval();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->interval)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->interval)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAPeriod(): void
    {
        expect($this->interval->setPeriod('Month'))->isInstanceOf(Interval::class);
    }

    /**
     * @depends testItCanSetAPeriod
     *
     * @return void
     */
    public function testItCanGetAPeriod(): void
    {
        $this->interval->setPeriod('Month');

        verify($this->interval->getPeriod())->string();
        verify($this->interval->getPeriod())->notEmpty();
        verify($this->interval->getPeriod())->equals('Month');
    }

    /**
     * @return void
     */
    public function testItCanSetAQuantity(): void
    {
        expect($this->interval->setQuantity(2))->isInstanceOf(Interval::class);
    }

    /**
     * @depends testItCanSetAQuantity
     *
     * @return void
     */
    public function testItCanGetAQuantity(): void
    {
        $this->interval->setQuantity(2);

        verify($this->interval->getQuantity())->int();
        verify($this->interval->getQuantity())->notEmpty();
        verify($this->interval->getQuantity())->equals(2);
    }

    /**
     * @return void
     */
    public function testItCanSetAValue(): void
    {
        expect($this->interval->setValue(2))->isInstanceOf(Interval::class);
    }

    /**
     * @depends testItCanSetAValue
     *
     * @return void
     */
    public function testItCanGetAValue(): void
    {
        $this->interval->setValue(2);

        verify($this->interval->getValue())->int();
        verify($this->interval->getValue())->notEmpty();
        verify($this->interval->getValue())->equals(2);
    }
}

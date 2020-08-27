<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Interval;

/**
 * Class IntervalTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class IntervalTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Interval
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Interval();
    }

    /**
     * @return void
     */
    public function testItCanSetAPeriod(): void
    {
        $this->tester->assertObjectHasMethod('setPeriod', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPeriod', $this->model);

        expect($this->model->setPeriod('Month'))->isInstanceOf(Interval::class);
    }

    /**
     * @depends testItCanSetAPeriod
     *
     * @return void
     */
    public function testItCanGetAPeriod(): void
    {
        $this->tester->assertObjectHasMethod('getPeriod', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPeriod', $this->model);

        $this->model->setPeriod('Month');

        verify($this->model->getPeriod())->string();
        verify($this->model->getPeriod())->notEmpty();
        verify($this->model->getPeriod())->equals('Month');
    }

    /**
     * @return void
     */
    public function testItCanSetAQuantity(): void
    {
        $this->tester->assertObjectHasMethod('setQuantity', $this->model);
        $this->tester->assertObjectMethodIsPublic('setQuantity', $this->model);

        expect($this->model->setQuantity(2))->isInstanceOf(Interval::class);
    }

    /**
     * @depends testItCanSetAQuantity
     *
     * @return void
     */
    public function testItCanGetAQuantity(): void
    {
        $this->tester->assertObjectHasMethod('getQuantity', $this->model);
        $this->tester->assertObjectMethodIsPublic('getQuantity', $this->model);

        $this->model->setQuantity(2);

        verify($this->model->getQuantity())->int();
        verify($this->model->getQuantity())->notEmpty();
        verify($this->model->getQuantity())->equals(2);
    }

    /**
     * @return void
     */
    public function testItCanSetAValue(): void
    {
        $this->tester->assertObjectHasMethod('setValue', $this->model);
        $this->tester->assertObjectMethodIsPublic('setValue', $this->model);

        expect($this->model->setValue(2))->isInstanceOf(Interval::class);
    }

    /**
     * @depends testItCanSetAValue
     *
     * @return void
     */
    public function testItCanGetAValue(): void
    {
        $this->tester->assertObjectHasMethod('getValue', $this->model);
        $this->tester->assertObjectMethodIsPublic('getValue', $this->model);

        $this->model->setValue(2);

        verify($this->model->getValue())->int();
        verify($this->model->getValue())->notEmpty();
        verify($this->model->getValue())->equals(2);
    }
}

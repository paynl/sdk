<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Amount;

/**
 * Class AmountTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class AmountTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Amount
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Amount();
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        $this->tester->assertObjectHasMethod('setAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmount', $this->model);

        expect($this->model->setAmount(100))->isInstanceOf(Amount::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->tester->assertObjectHasMethod('getAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmount', $this->model);

        // check initial value
        verify($this->model->getAmount())->int();
        verify($this->model->getAmount())->isEmpty();
        verify($this->model->getAmount())->equals(0);

        // set new value
        $this->model->setAmount(100);

        verify($this->model->getAmount())->equals(100);
    }

    /**
     * @return void
     */
    public function testItCanSetACurrency(): void
    {
        $this->tester->assertObjectHasMethod('setCurrency', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCurrency', $this->model);

        expect($this->model->setCurrency('USD'))->isInstanceOf(Amount::class);
    }

    /**
     * @depends testItCanSetACurrency
     *
     * @return void
     */
    public function testItCanGetACurrency(): void
    {
        $this->tester->assertObjectHasMethod('getCurrency', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCurrency', $this->model);

// check initial value
        verify($this->model->getCurrency())->string();
        verify($this->model->getCurrency())->notEmpty();
        verify($this->model->getCurrency())->equals('EUR');

        // set new value
        $this->model->setCurrency('USD');

        verify($this->model->getCurrency())->equals('USD');
    }
}

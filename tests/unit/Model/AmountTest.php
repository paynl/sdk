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
     * @return void
     */
    public function _before(): void
    {
        $this->shouldItBeJsonSerializable = true;
        $this->model = new Amount();
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->model->setAmount(100))->isInstanceOf(Amount::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
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
        expect($this->model->setCurrency('USD'))->isInstanceOf(Amount::class);
    }

    /**
     * @depends testItCanSetACurrency
     *
     * @return void
     */
    public function testItCanGetACurrency(): void
    {
        // check initial value
        verify($this->model->getCurrency())->string();
        verify($this->model->getCurrency())->notEmpty();
        verify($this->model->getCurrency())->equals('EUR');

        // set new value
        $this->model->setCurrency('USD');

        verify($this->model->getCurrency())->equals('USD');
    }
}

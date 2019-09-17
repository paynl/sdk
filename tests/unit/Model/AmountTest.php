<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Model\Amount;
use PayNL\Sdk\Model\ModelInterface;

/**
 * Class AmountTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class AmountTest extends UnitTest
{
    /**
     * @var Amount
     */
    protected $amount;

    public function _before(): void
    {
        $this->amount = new Amount();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->amount)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->amount)->isInstanceOf(\JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->amount->setAmount(100))->isInstanceOf(Amount::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        // check initial value
        verify($this->amount->getAmount())->int();
        verify($this->amount->getAmount())->isEmpty();
        verify($this->amount->getAmount())->equals(0);

        // set new value
        $this->amount->setAmount(100);

        verify($this->amount->getAmount())->equals(100);
    }

    /**
     * @return void
     */
    public function testItCanSetACurrency(): void
    {
        expect($this->amount->setCurrency('USD'))->isInstanceOf(Amount::class);
    }

    /**
     * @depends testItCanSetACurrency
     *
     * @return void
     */
    public function testItCanGetACurrency(): void
    {
        // check initial value
        verify($this->amount->getCurrency())->string();
        verify($this->amount->getCurrency())->notEmpty();
        verify($this->amount->getCurrency())->equals('EUR');

        // set new value
        $this->amount->setCurrency('USD');

        verify($this->amount->getCurrency())->equals('USD');
    }
}

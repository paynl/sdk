<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Amount,
    RecurringTransaction
};
use JsonSerializable;

/**
 * Class RecurringTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RecurringTransactionTest extends UnitTest
{
    /**
     * @var RecurringTransaction
     */
    protected $recurringTransaction;

    public function _before(): void
    {
        $this->recurringTransaction = new RecurringTransaction();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->recurringTransaction)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->recurringTransaction)->isInstanceOf(JsonSerializable::class);

        verify($this->recurringTransaction->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->recurringTransaction->setAmount(new Amount()))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->recurringTransaction->setAmount(new Amount());

        verify($this->recurringTransaction->getAmount())->notEmpty();
        verify($this->recurringTransaction->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->recurringTransaction->setDescription('Recurring'))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->recurringTransaction->setDescription('Recurring');

        verify($this->recurringTransaction->getDescription())->string();
        verify($this->recurringTransaction->getDescription())->notEmpty();
        verify($this->recurringTransaction->getDescription())->equals('Recurring');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra1(): void
    {
        expect($this->recurringTransaction->setExtra1('Extra'))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetExtra1
     *
     * @return void
     */
    public function testItCanGetExtra1(): void
    {
        $this->recurringTransaction->setExtra1('Extra');

        verify($this->recurringTransaction->getExtra1())->string();
        verify($this->recurringTransaction->getExtra1())->notEmpty();
        verify($this->recurringTransaction->getExtra1())->equals('Extra');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra2(): void
    {
        expect($this->recurringTransaction->setExtra2('Extra'))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetExtra2
     *
     * @return void
     */
    public function testItCanGetExtra2(): void
    {
        $this->recurringTransaction->setExtra2('Extra');

        verify($this->recurringTransaction->getExtra2())->string();
        verify($this->recurringTransaction->getExtra2())->notEmpty();
        verify($this->recurringTransaction->getExtra2())->equals('Extra');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra3(): void
    {
        expect($this->recurringTransaction->setExtra3('Extra'))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetExtra3
     *
     * @return void
     */
    public function testItCanGetExtra3(): void
    {
        $this->recurringTransaction->setExtra3('Extra');

        verify($this->recurringTransaction->getExtra3())->string();
        verify($this->recurringTransaction->getExtra3())->notEmpty();
        verify($this->recurringTransaction->getExtra3())->equals('Extra');
    }
}

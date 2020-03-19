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
use PayNL\Sdk\Common\JsonSerializeTrait;
use UnitTester;

/**
 * Class RecurringTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RecurringTransactionTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

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
    }

    /**
     * @return void
     */
    public function testItHasJsonSerializeTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->recurringTransaction), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        verify($this->recurringTransaction->setAmount($amountMock))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        $this->recurringTransaction->setAmount($amountMock);

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

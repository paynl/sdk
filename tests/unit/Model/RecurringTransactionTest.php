<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Amount,
    RecurringTransaction
};

/**
 * Class RecurringTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RecurringTransactionTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var RecurringTransaction
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new RecurringTransaction();
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        $this->tester->assertObjectHasMethod('setAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmount', $this->model);

        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        verify($this->model->setAmount($amountMock))->isInstanceOf(RecurringTransaction::class);
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

        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        $this->model->setAmount($amountMock);

        verify($this->model->getAmount())->notEmpty();
        verify($this->model->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        expect($this->model->setDescription('Recurring'))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->tester->assertObjectHasMethod('getDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDescription', $this->model);

        $this->model->setDescription('Recurring');

        verify($this->model->getDescription())->string();
        verify($this->model->getDescription())->notEmpty();
        verify($this->model->getDescription())->equals('Recurring');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra1(): void
    {
        $this->tester->assertObjectHasMethod('setExtra1', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExtra1', $this->model);

        expect($this->model->setExtra1('Extra'))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetExtra1
     *
     * @return void
     */
    public function testItCanGetExtra1(): void
    {
        $this->tester->assertObjectHasMethod('getExtra1', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExtra1', $this->model);

        $this->model->setExtra1('Extra');

        verify($this->model->getExtra1())->string();
        verify($this->model->getExtra1())->notEmpty();
        verify($this->model->getExtra1())->equals('Extra');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra2(): void
    {
        $this->tester->assertObjectHasMethod('setExtra2', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExtra2', $this->model);

        expect($this->model->setExtra2('Extra'))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetExtra2
     *
     * @return void
     */
    public function testItCanGetExtra2(): void
    {
        $this->tester->assertObjectHasMethod('getExtra2', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExtra2', $this->model);

        $this->model->setExtra2('Extra');

        verify($this->model->getExtra2())->string();
        verify($this->model->getExtra2())->notEmpty();
        verify($this->model->getExtra2())->equals('Extra');
    }

    /**
     * @return void
     */
    public function testItCanSetExtra3(): void
    {
        $this->tester->assertObjectHasMethod('setExtra3', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExtra3', $this->model);

        expect($this->model->setExtra3('Extra'))->isInstanceOf(RecurringTransaction::class);
    }

    /**
     * @depends testItCanSetExtra3
     *
     * @return void
     */
    public function testItCanGetExtra3(): void
    {
        $this->tester->assertObjectHasMethod('getExtra3', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExtra3', $this->model);

        $this->model->setExtra3('Extra');

        verify($this->model->getExtra3())->string();
        verify($this->model->getExtra3())->notEmpty();
        verify($this->model->getExtra3())->equals('Extra');
    }
}

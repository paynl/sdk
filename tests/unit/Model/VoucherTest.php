<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Amount,
    Voucher
};

/**
 * Class VoucherTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class VoucherTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Voucher
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Voucher();
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        $this->tester->assertObjectHasMethod('setAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmount', $this->model);

        expect($this->model->setAmount(new Amount()))->isInstanceOf(Voucher::class);
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

        $this->model->setAmount(new Amount());

        verify($this->model->getAmount())->notEmpty();
        verify($this->model->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAPinCode(): void
    {
        $this->tester->assertObjectHasMethod('setPinCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPinCode', $this->model);

        expect($this->model->setPinCode('1234'))->isInstanceOf(Voucher::class);
    }

    /**
     * @depends testItCanSetAPinCode
     *
     * @return void
     */
    public function testItCanGetAPinCode(): void
    {
        $this->tester->assertObjectHasMethod('getPinCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPinCode', $this->model);

        $this->model->setPinCode('1234');

        verify($this->model->getPinCode())->string();
        verify($this->model->getPinCode())->notEmpty();
        verify($this->model->getPinCode())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanSetAPosId(): void
    {
        $this->tester->assertObjectHasMethod('setPosId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPosId', $this->model);

        expect($this->model->setPosId('1234'))->isInstanceOf(Voucher::class);
    }

    /**
     * @depends testItCanSetAPosId
     *
     * @return void
     */
    public function testItCanGetAPosId(): void
    {
        $this->tester->assertObjectHasMethod('getPosId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPosId', $this->model);

        $this->model->setPosId('1234');

        verify($this->model->getPosId())->string();
        verify($this->model->getPosId())->notEmpty();
        verify($this->model->getPosId())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanSetBalance(): void
    {
        $this->tester->assertObjectHasMethod('setBalance', $this->model);
        $this->tester->assertObjectMethodIsPublic('setBalance', $this->model);

        $voucher = $this->model->setBalance(400);
        verify($voucher)->isInstanceOf(Voucher::class);
        verify($voucher)->same($this->model);
    }

    /**
     * @depends testItCanSetBalance
     *
     * @return void
     */
    public function testItCanGetBalance(): void
    {
        $this->tester->assertObjectHasMethod('getBalance', $this->model);
        $this->tester->assertObjectMethodIsPublic('getBalance', $this->model);

        verify($this->model->getBalance())->null();

        $this->model->setBalance(400);
        $balance = $this->model->getBalance();
        verify($balance)->int();
        verify($balance)->notEmpty();
        verify($balance)->equals(400);
    }

    /**
     * @return void
     */
    public function testItCanSetNumber(): void
    {
        $this->tester->assertObjectHasMethod('setNumber', $this->model);
        $this->tester->assertObjectMethodIsPublic('setNumber', $this->model);

        $voucher = $this->model->setNumber('foo');
        verify($voucher)->isInstanceOf(Voucher::class);
        verify($voucher)->same($this->model);
    }

    /**
     * @depends testItCanSetNumber
     *
     * @return void
     */
    public function testItCanGetNumber(): void
    {
        $this->tester->assertObjectHasMethod('getNumber', $this->model);
        $this->tester->assertObjectMethodIsPublic('getNumber', $this->model);

        verify($this->model->getNumber())->null();

        $this->model->setNumber('foo');
        $balance = $this->model->getNumber();
        verify($balance)->string();
        verify($balance)->notEmpty();
        verify($balance)->equals('foo');
    }
}

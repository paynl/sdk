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
}

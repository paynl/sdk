<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Amount,
    Voucher
};
use JsonSerializable;

/**
 * Class VoucherTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class VoucherTest extends UnitTest
{
    /**
     * @var Voucher
     */
    protected $voucher;

    public function _before(): void
    {
        $this->voucher = new Voucher();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->voucher)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->voucher)->isInstanceOf(JsonSerializable::class);

        verify($this->voucher->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->voucher->setAmount(new Amount()))->isInstanceOf(Voucher::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->voucher->setAmount(new Amount());

        verify($this->voucher->getAmount())->notEmpty();
        verify($this->voucher->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAPinCode(): void
    {
        expect($this->voucher->setPinCode('1234'))->isInstanceOf(Voucher::class);
    }

    /**
     * @depends testItCanSetAPinCode
     *
     * @return void
     */
    public function testItCanGetAPinCode(): void
    {
        $this->voucher->setPinCode('1234');

        verify($this->voucher->getPinCode())->string();
        verify($this->voucher->getPinCode())->notEmpty();
        verify($this->voucher->getPinCode())->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanSetAPosId(): void
    {
        expect($this->voucher->setPosId('1234'))->isInstanceOf(Voucher::class);
    }

    /**
     * @depends testItCanSetAPosId
     *
     * @return void
     */
    public function testItCanGetAPosId(): void
    {
        $this->voucher->setPosId('1234');

        verify($this->voucher->getPosId())->string();
        verify($this->voucher->getPosId())->notEmpty();
        verify($this->voucher->getPosId())->equals('1234');
    }
}

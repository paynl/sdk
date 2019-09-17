<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Amount;
use PayNL\Sdk\Model\Refund;
use PayNL\Sdk\Model\ModelInterface;

/**
 * Class RefundTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RefundTest extends UnitTest
{
    /**
     * @var Refund
     */
    protected $refund;

    public function _before(): void
    {
        $this->refund = new Refund();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->refund)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->refund)->isInstanceOf(\JsonSerializable::class);

        verify($this->refund->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentSessionId(): void
    {
        expect($this->refund->setPaymentSessionId('100000000'))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAPaymentSessionId
     *
     * @return void
     */
    public function testItCanGetAPaymentSessionId(): void
    {
        $this->refund->setPaymentSessionId('100000000');

        verify($this->refund->getPaymentSessionId())->string();
        verify($this->refund->getPaymentSessionId())->notEmpty();
        verify($this->refund->getPaymentSessionId())->equals('100000000');
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->refund->setAmount(new Amount()))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->refund->setAmount(new Amount());

        verify($this->refund->getAmount())->notEmpty();
        verify($this->refund->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->refund->setDescription('Refund description'))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->refund->setDescription('Refund description');

        verify($this->refund->getDescription())->string();
        verify($this->refund->getDescription())->notEmpty();
        verify($this->refund->getDescription())->equals('Refund description');
    }
}

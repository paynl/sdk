<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\{
    Model\Amount,
    Model\Refund,
    Model\RefundTransaction
};

/**
 * Class RefundTransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RefundTransactionTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var RefundTransaction
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new RefundTransaction();
    }

    /**
     * @return Amount
     */
    private function getMockAmount(): Amount
    {
        return $this->tester->grabMockService('modelManager')->get(Amount::class);
    }

    /**
     * @return Refund
     */
    private function getMockRefund(): Refund
    {
        return $this->tester->grabMockService('modelManager')->get(Refund::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAmount(): void
    {
        $this->tester->assertObjectHasMethod('setAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmount', $this->model);

        $refundTransaction = $this->model->setAmount($this->getMockAmount());
        verify($refundTransaction)->object();
        verify($refundTransaction)->same($this->model);
    }

    /**
     * @depends testItCanSetAmount
     *
     * @return void
     */
    public function testItCanGetAmount(): void
    {
        $this->tester->assertObjectHasMethod('getAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmount', $this->model);

        $mockAmount = $this->getMockAmount();
        $this->model->setAmount($mockAmount);
        $amount = $this->model->getAmount();
        verify($amount)->object();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount)->same($mockAmount);
    }

    /**
     * @return void
     */
    public function testItCanSetAmountRefunded(): void
    {
        $this->tester->assertObjectHasMethod('setAmountRefunded', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmountRefunded', $this->model);

        $refundTransaction = $this->model->setAmountRefunded($this->getMockAmount());
        verify($refundTransaction)->object();
        verify($refundTransaction)->same($this->model);
    }

    /**
     * @depends testItCanSetAmountRefunded
     *
     * @return void
     */
    public function testItCanGetAmountRefunded(): void
    {
        $this->tester->assertObjectHasMethod('getAmountRefunded', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmountRefunded', $this->model);

        $mockAmount = $this->getMockAmount();
        $this->model->setAmountRefunded($mockAmount);
        $amount = $this->model->getAmountRefunded();
        verify($amount)->object();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount)->same($mockAmount);
    }

    /**
     * @return void
     */
    public function testItCanSetRefund(): void
    {
        $this->tester->assertObjectHasMethod('setRefund', $this->model);
        $this->tester->assertObjectMethodIsPublic('setRefund', $this->model);

        $refundTransaction = $this->model->setRefund($this->getMockRefund());
        verify($refundTransaction)->object();
        verify($refundTransaction)->same($this->model);
    }

    /**
     * @depends testItCanSetRefund
     *
     * @return void
     */
    public function testItCanGetRefund(): void
    {
        $this->tester->assertObjectHasMethod('getRefund', $this->model);
        $this->tester->assertObjectMethodIsPublic('getRefund', $this->model);

        $mockRefund = $this->getMockRefund();
        $this->model->setRefund($mockRefund);
        $amount = $this->model->getRefund();
        verify($amount)->object();
        verify($amount)->isInstanceOf(Refund::class);
        verify($amount)->same($mockRefund);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    RefundOverview,
    Amount,
    RefundTransaction
};
use TypeError;

/**
 * Class RefundOverviewTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RefundOverviewTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var RefundOverview
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new RefundOverview();
    }

    /**
     * @return Amount
     */
    private function getMockAmount(): Amount
    {
        return $this->tester->grabMockService('modelManager')->get(Amount::class);
    }

    /**
     * @return RefundTransaction
     */
    private function getMockRefundTransaction(): RefundTransaction
    {
        return $this->tester->grabService('modelManager')->build(RefundTransaction::class);
    }

    /**
     * @return void
     */
    public function testItCanSetDescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        $service = $this->model->setDescription('foo');
        verify($service)->object();
        verify($service)->same($this->model);
    }

    /**
     * @depends testItCanSetDescription
     *
     * @return void
     */
    public function testItCanGetDescription(): void
    {
        $this->tester->assertObjectHasMethod('getDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDescription', $this->model);

        $description = $this->model->getDescription();
        verify($description)->string();
        verify($description)->isEmpty();

        $this->model->setDescription('foo');
        $description = $this->model->getDescription();
        verify($description)->string();
        verify($description)->notEmpty();
        verify($description)->equals('foo');
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

        $amountRefunded = $this->model->getAmountRefunded();
        verify($amountRefunded)->isInstanceOf(Amount::class);

        $mockAmount = $this->getMockAmount();
        $this->model->setAmountRefunded($mockAmount);
        $amount = $this->model->getAmountRefunded();
        verify($amount)->object();
        verify($amount)->isInstanceOf(Amount::class);
        verify($amount)->same($mockAmount);
        verify($amount)->notSame($amountRefunded);
    }

    /**
     * @return void
     */
    public function testItCanGetRefundedTransactions(): void
    {
        $this->tester->assertObjectHasMethod('getRefundedTransactions', $this->model);
        $this->tester->assertObjectMethodIsPublic('getRefundedTransactions', $this->model);

        $refundedTransactions = $this->model->getRefundedTransactions();
        verify($refundedTransactions)->array();
        verify($refundedTransactions)->count(0);
    }

    /**
     * @depends testItCanGetRefundedTransactions
     *
     * @return void
     */
    public function testItCanAddRefundTransaction(): void
    {
        $this->tester->assertObjectHasMethod('addRefundTransaction', $this->model);
        $this->tester->assertObjectMethodIsPublic('addRefundTransaction', $this->model);

        $mockRefundTransaction = $this->getMockRefundTransaction();
        $refundOverview = $this->model->addRefundTransaction($mockRefundTransaction);
        verify($refundOverview)->object();
        verify($refundOverview)->same($this->model);
        verify($refundOverview->getRefundedTransactions())->contains($mockRefundTransaction);
    }

    /**
     * @depends testItCanAddRefundTransaction
     * @depends testItCanGetRefundedTransactions
     *
     * @return void
     */
    public function testItCanSetRefundedTransactions(): void
    {
        $this->tester->assertObjectHasMethod('setRefundedTransactions', $this->model);
        $this->tester->assertObjectMethodIsPublic('setRefundedTransactions', $this->model);

        $mockRefundTransaction = $this->getMockRefundTransaction();

        $refundOverview = $this->model->setRefundedTransactions([ $mockRefundTransaction ]);
        verify($refundOverview)->object();
        verify($refundOverview)->same($this->model);
        $refundedTransactions = $this->model->getRefundedTransactions();
        verify($refundedTransactions)->containsOnlyInstancesOf(RefundTransaction::class);
        verify($refundedTransactions)->notEmpty();
        verify($refundedTransactions)->count(1);

        $refundOverview = $this->model->setRefundedTransactions([
            $this->getMockRefundTransaction(),
            $this->getMockRefundTransaction()
        ]);
        verify($refundOverview)->object();
        verify($refundOverview)->same($this->model);
        $refundedTransactions = $this->model->getRefundedTransactions();
        verify($refundedTransactions)->containsOnlyInstancesOf(RefundTransaction::class);
        verify($refundedTransactions)->count(2);
        verify($refundedTransactions)->notContains($mockRefundTransaction);
    }

    /**
     * @depends testItCanAddRefundTransaction
     * @depends testItCanSetRefundedTransactions
     *
     * @return void
     */
    public function testSetRefundedTransactionsThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setRefundedTransactions([$this->getMockRefundTransaction(), []]);
    }

    /**
     * @depends testItCanAddRefundTransaction
     * @depends testItCanSetRefundedTransactions
     * @depends testItCanGetRefundedTransactions
     *
     * @return void
     */
    public function testItCanSetEmptyRefundedTransactions(): void
    {
        $refundOverview = $this->model->setRefundedTransactions([]);
        verify($refundOverview)->object();
        verify($refundOverview)->same($this->model);
        verify($refundOverview->getRefundedTransactions())->count(0);
    }

    /**
     * @return void
     */
    public function testItCanGetFailedTransactions(): void
    {
        $this->tester->assertObjectHasMethod('getFailedTransactions', $this->model);
        $this->tester->assertObjectMethodIsPublic('getFailedTransactions', $this->model);

        $failedTransactions = $this->model->getFailedTransactions();
        verify($failedTransactions)->array();
        verify($failedTransactions)->count(0);
    }

    /**
     * @depends testItCanGetFailedTransactions
     *
     * @return void
     */
    public function testItCanAddFailedTransaction(): void
    {
        $this->tester->assertObjectHasMethod('addFailedTransaction', $this->model);
        $this->tester->assertObjectMethodIsPublic('addFailedTransaction', $this->model);

        $mockRefundTransaction = $this->getMockRefundTransaction();
        $refundOverview = $this->model->addFailedTransaction($mockRefundTransaction);
        verify($refundOverview)->object();
        verify($refundOverview)->same($this->model);
        verify($refundOverview->getFailedTransactions())->contains($mockRefundTransaction);
    }

    /**
     * @depends testItCanAddFailedTransaction
     * @depends testItCanGetFailedTransactions
     *
     * @return void
     */
    public function testItCanSetFailedTransactions(): void
    {
        $this->tester->assertObjectHasMethod('setFailedTransactions', $this->model);
        $this->tester->assertObjectMethodIsPublic('setFailedTransactions', $this->model);

        $mockRefundTransaction = $this->getMockRefundTransaction();

        $refundOverview = $this->model->setFailedTransactions([ $mockRefundTransaction ]);
        verify($refundOverview)->object();
        verify($refundOverview)->same($this->model);
        $failedTransactions = $this->model->getFailedTransactions();
        verify($failedTransactions)->containsOnlyInstancesOf(RefundTransaction::class);
        verify($failedTransactions)->notEmpty();
        verify($failedTransactions)->count(1);

        $refundOverview = $this->model->setFailedTransactions([
            $this->getMockRefundTransaction(),
            $this->getMockRefundTransaction()
        ]);
        verify($refundOverview)->object();
        verify($refundOverview)->same($this->model);
        $failedTransactions = $this->model->getFailedTransactions();
        verify($failedTransactions)->containsOnlyInstancesOf(RefundTransaction::class);
        verify($failedTransactions)->count(2);
        verify($failedTransactions)->notContains($mockRefundTransaction);
    }

    /**
     * @depends testItCanAddRefundTransaction
     * @depends testItCanSetFailedTransactions
     *
     * @return void
     */
    public function testSetFailedTransactionsThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setFailedTransactions([$this->getMockRefundTransaction(), []]);
    }

    /**
     * @depends testItCanAddFailedTransaction
     * @depends testItCanSetFailedTransactions
     * @depends testItCanGetFailedTransactions
     *
     * @return void
     */
    public function testItCanSetEmptyFailedTransactions(): void
    {
        $refundOverview = $this->model->setFailedTransactions([]);
        verify($refundOverview)->object();
        verify($refundOverview)->same($this->model);
        verify($refundOverview->getFailedTransactions())->count(0);
    }
}

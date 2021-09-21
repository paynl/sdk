<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{Amount, RefundTransaction, RefundedTransactions};
use TypeError;

/**
 * Class RefundedTransactionsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RefundedTransactionsTest extends UnitTest
{
    use ModelTestTrait, CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
        testItCanGetCollectionName as traitTestItCanGetCollectionName;
    }

    /**
     * @var RefundTransactions
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new RefundedTransactions();
    }

    /**
     * @param int $amount
     * @param string $currency
     * @return RefundTransaction
     */
    private function getMockRefundTransaction(int $amount, string $currency = 'EUR'): RefundTransaction
    {
        /** @var RefundTransaction $refundTransaction */
        $refundTransaction = $this->tester->grabService('modelManager')->build(RefundTransaction::class);
        $amountObj = new Amount();
        $amountObj->setAmount($amount);
        $amountObj->setCurrency($currency);
        $refundTransaction->setAmount($amountObj);
        return $refundTransaction;
    }

    /**
     * @return void
     */
    public function testItCanAddRefundTransaction(): void
    {
        $this->tester->assertObjectHasMethod('addRefundTransaction', $this->model);
        $this->tester->assertObjectMethodIsPublic('addRefundTransaction', $this->model);

        $mockRefundTransaction = $this->getMockRefundTransaction(5);

        $refundTransactions = $this->model->addRefundTransaction($mockRefundTransaction);
        verify($refundTransactions)->object();
        verify($refundTransactions)->same($this->model);
        verify($refundTransactions)->hasKey(0);
    }

    /**
     * @depends testItCanAddRefundTransaction
     *
     * @return void
     */
    public function testItCanSetRefundTransactions(): void
    {
        $this->tester->assertObjectHasMethod('setRefundedTransactions', $this->model);
        $this->tester->assertObjectMethodIsPublic('setRefundedTransactions', $this->model);

        $mockRefundTransaction = $this->getMockRefundTransaction(5);

        $refundTransactions = $this->model->setRefundedTransactions([$mockRefundTransaction]);
        verify($refundTransactions)->object();
        verify($refundTransactions)->same($this->model);
        verify($refundTransactions)->containsOnlyInstancesOf(RefundTransaction::class);
        verify($refundTransactions)->notEmpty();
        verify($refundTransactions)->count(1);

        $refundTransactions = $this->model->setRefundedTransactions([
            $this->getMockRefundTransaction(100),
            $this->getMockRefundTransaction(200),
        ]);
        verify($refundTransactions)->object();
        verify($refundTransactions)->same($this->model);
        verify($refundTransactions)->containsOnlyInstancesOf(RefundTransaction::class);
        verify($refundTransactions)->count(2);
        verify($refundTransactions)->notContains($mockRefundTransaction);
    }

    /**
     * @depends testItCanAddRefundTransaction
     * @depends testItCanSetRefundTransactions
     *
     * @return void
     */
    public function testSetRefundedTransactionsThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setRefundedTransactions([$this->getMockRefundTransaction(5), []]);
    }

    /**
     * @depends testItCanAddRefundTransaction
     * @depends testItCanSetRefundTransactions
     *
     * @return void
     */
    public function testItCanSetEmptyRefundedTransactions(): void
    {
        $refundTransactions = $this->model->setRefundedTransactions([]);
        verify($refundTransactions)->isInstanceOf(RefundedTransactions::class);
        verify($refundTransactions)->same($this->model);
        verify($refundTransactions)->count(0);
    }

    /**
     * @depends testItCanSetRefundTransactions
     *
     * @return void
     */
    public function testItCanGetRefundedTransactions(): void
    {
        $this->tester->assertObjectHasMethod('getRefundedTransactions', $this->model);
        $this->tester->assertObjectMethodIsPublic('getRefundedTransactions', $this->model);

        $mockRefundTransaction = $this->getMockRefundTransaction(5);

        $this->model->setRefundedTransactions([$mockRefundTransaction]);
        $refundTransactions = $this->model->getRefundedTransactions();
        verify($refundTransactions)->array();
        verify($refundTransactions)->count(1);
        verify($refundTransactions)->hasKey(0);
        verify($refundTransactions)->containsOnlyInstancesOf(RefundTransaction::class);
    }

    /**
     * @depends testItCanSetRefundTransactions
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $this->model->setRefundedTransactions([ $this->getMockRefundTransaction(5) ]);

        // offsetExists
        verify(isset($this->model[0]))->true();
        verify(isset($this->model[1]))->false();

        // offsetGet
        verify($this->model[0])->isInstanceOf(RefundTransaction::class);

        // offsetSet
        $this->model[1] = $this->getMockRefundTransaction(6);
        verify($this->model)->hasKey(0);
        verify($this->model)->hasKey(1);
        verify($this->model)->count(2);

        // offsetUnset
        unset($this->model[0]);
        verify($this->model)->count(1);
        verify($this->model)->hasNotKey(0);
    }

    /**
     * @inheritDoc
     */
    public function testItCanGetCollectionName(): void
    {
        $this->traitTestItCanGetCollectionName();
        verify($this->model->getCollectionName())->equals('refundedTransactions');
    }
}

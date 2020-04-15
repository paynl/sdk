<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use Mockery;
use PayNL\Sdk\Model\{
    Amount,
    BankAccount,
    Products,
    Refund,
    Status
};
use DateTime;

/**
 * Class RefundTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RefundTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Refund
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Refund();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        verify($this->model->setId('12345'))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAnId
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $refundId = '12345';
        $this->model->setId($refundId);
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->string();
        verify($this->model->getId())->equals($refundId);
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentSessionId(): void
    {
        $this->tester->assertObjectHasMethod('setPaymentSessionId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPaymentSessionId', $this->model);

        expect($this->model->setPaymentSessionId('100000000'))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAPaymentSessionId
     *
     * @return void
     */
    public function testItCanGetAPaymentSessionId(): void
    {
        $this->tester->assertObjectHasMethod('getPaymentSessionId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPaymentSessionId', $this->model);

        $this->model->setPaymentSessionId('100000000');

        verify($this->model->getPaymentSessionId())->string();
        verify($this->model->getPaymentSessionId())->notEmpty();
        verify($this->model->getPaymentSessionId())->equals('100000000');
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        $this->tester->assertObjectHasMethod('setAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmount', $this->model);

        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        verify($this->model->setAmount($amountMock))->isInstanceOf(Refund::class);
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

        /** @var Amount $amountMock */
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        $amountMock->setAmount(12345);
        $this->model->setAmount($amountMock);

        verify($this->model->getAmount())->notEmpty();
        verify($this->model->getAmount())->isInstanceOf(Amount::class);
        verify($this->model->getAmount())->equals($amountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        expect($this->model->setDescription('Refund description'))->isInstanceOf(Refund::class);
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

        $this->model->setDescription('Refund description');

        verify($this->model->getDescription())->string();
        verify($this->model->getDescription())->notEmpty();
        verify($this->model->getDescription())->equals('Refund description');
    }

    /**
     * @return void
     */
    public function testItCanSetABankAccount(): void
    {
        $this->tester->assertObjectHasMethod('setBankAccount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setBankAccount', $this->model);

        $bankAccountMock = $this->tester->grabService('modelManager')->get('BankAccount');
        expect($this->model->setBankAccount($bankAccountMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetABankAccount
     *
     * @return void
     */
    public function testItCanGetABankAccount(): void
    {
        $this->tester->assertObjectHasMethod('getBankAccount', $this->model);
        $this->tester->assertObjectMethodIsPublic('getBankAccount', $this->model);

        /** @var BankAccount $bankAccountMock */
        $bankAccountMock = $this->tester->grabService('modelManager')->get('BankAccount');
        $bankAccountMock->setBank('Rabobank');
        $this->model->setBankAccount($bankAccountMock);

        verify($this->model->getBankAccount())->notEmpty();
        verify($this->model->getBankAccount())->isInstanceOf(BankAccount::class);
        verify($this->model->getBankAccount())->same($bankAccountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAStatus(): void
    {
        $this->tester->assertObjectHasMethod('setStatus', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStatus', $this->model);

        $statusMock = $this->tester->grabService('modelManager')->get('Status');
        expect($this->model->setStatus($statusMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAStatus
     *
     * @return void
     */
    public function testItCanGetAStatus(): void
    {
        $this->tester->assertObjectHasMethod('getStatus', $this->model);
        $this->tester->assertObjectMethodIsPublic('getStatus', $this->model);

        /** @var Status $statusMock */
        $statusMock = $this->tester->grabService('modelManager')->get('Status');
        $statusMock->setName('John Doe');
        $this->model->setStatus($statusMock);

        verify($this->model->getStatus())->notEmpty();
        verify($this->model->getStatus())->isInstanceOf(Status::class);
        verify($this->model->getStatus())->equals($statusMock);
    }

    /**
     * @return void
     */
    public function testItCanAddAProduct(): void
    {
        $this->tester->assertObjectHasMethod('addProduct', $this->model);
        $this->tester->assertObjectMethodIsPublic('addProduct', $this->model);

        $productMock = $this->tester->grabService('modelManager')->get('Product');
        expect($this->model->addProduct($productMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanAddAProduct
     *
     * @return void
     */
    public function testItCanSetProducts(): void
    {
        $this->tester->assertObjectHasMethod('setProducts', $this->model);
        $this->tester->assertObjectMethodIsPublic('setProducts', $this->model);

        $productsMock = $this->tester->grabService('modelManager')->get('Products');
        verify($this->model->setProducts($productsMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetProducts
     *
     * @return void
     */
    public function testItCanGetProducts(): void
    {
        $this->tester->assertObjectHasMethod('getProducts', $this->model);
        $this->tester->assertObjectMethodIsPublic('getProducts', $this->model);

        /** @var Products $productsMock */
        $productsMock = $this->tester->grabService('modelManager')->get('Products');
        $this->model->setProducts($productsMock);
        verify($this->model->getProducts())->isInstanceOf(Products::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAReason(): void
    {
        $this->tester->assertObjectHasMethod('setReason', $this->model);
        $this->tester->assertObjectMethodIsPublic('setReason', $this->model);

        expect($this->model->setReason('Some reason why'))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAReason
     *
     * @return void
     */
    public function testItCanGetAReason(): void
    {
        $this->tester->assertObjectHasMethod('getReason', $this->model);
        $this->tester->assertObjectMethodIsPublic('getReason', $this->model);

        $this->model->setReason('Some reason why');

        verify($this->model->getReason())->string();
        verify($this->model->getReason())->notEmpty();
        verify($this->model->getReason())->equals('Some reason why');
    }

    /**
     * @return void
     */
    public function testItCanSetAProcessDate(): void
    {
        $this->tester->assertObjectHasMethod('setProcessDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('setProcessDate', $this->model);

        $dateTimeMock = Mockery::mock('DateTime');
        expect($this->model->setProcessDate($dateTimeMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAProcessDate
     *
     * @return void
     */
    public function testItCanGetAProcessDate(): void
    {
        $this->tester->assertObjectHasMethod('getProcessDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('getProcessDate', $this->model);

        $dateTimeMock = Mockery::mock('DateTime');
        $this->model->setProcessDate($dateTimeMock);

        verify($this->model->getProcessDate())->notEmpty();
        verify($this->model->getProcessDate())->isInstanceOf(DateTime::class);
    }
}

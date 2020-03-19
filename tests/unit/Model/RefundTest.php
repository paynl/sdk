<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use Mockery;
use PayNL\Sdk\Model\{ModelInterface, Amount, BankAccount, Product, Products, Refund, Status};
use JsonSerializable, TypeError, stdClass;
use DateTime;
use PayNL\Sdk\Common\JsonSerializeTrait;
use UnitTester;

/**
 * Class RefundTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RefundTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;
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
        verify($this->refund)->isInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItHasJsonSerializeTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->refund), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        verify($this->refund->setId('12345'))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAnId
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $refundId = '12345';
        $this->refund->setId($refundId);
        verify($this->refund->getId())->notEmpty();
        verify($this->refund->getId())->string();
        verify($this->refund->getId())->equals($refundId);
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
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        verify($this->refund->setAmount($amountMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        /** @var Amount $amountMock */
        $amountMock = $this->tester->grabService('modelManager')->get('Amount');
        $amountMock->setAmount(12345);
        $this->refund->setAmount($amountMock);

        verify($this->refund->getAmount())->notEmpty();
        verify($this->refund->getAmount())->isInstanceOf(Amount::class);
        verify($this->refund->getAmount())->equals($amountMock);
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

    /**
     * @return void
     */
    public function testItCanSetABankAccount(): void
    {
        $bankAccountMock = $this->tester->grabService('modelManager')->get('BankAccount');
        expect($this->refund->setBankAccount($bankAccountMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetABankAccount
     *
     * @return void
     */
    public function testItCanGetABankAccount(): void
    {
        /** @var BankAccount $bankAccountMock */
        $bankAccountMock = $this->tester->grabService('modelManager')->get('BankAccount');
        $bankAccountMock->setBank('Rabobank');
        $this->refund->setBankAccount($bankAccountMock);

        verify($this->refund->getBankAccount())->notEmpty();
        verify($this->refund->getBankAccount())->isInstanceOf(BankAccount::class);
        verify($this->refund->getBankAccount())->equals($bankAccountMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAStatus(): void
    {
        $statusMock = $this->tester->grabService('modelManager')->get('Status');
        expect($this->refund->setStatus($statusMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAStatus
     *
     * @return void
     */
    public function testItCanGetAStatus(): void
    {
        /** @var Status $statusMock */
        $statusMock = $this->tester->grabService('modelManager')->get('Status');
        $statusMock->setName('John Doe');
        $this->refund->setStatus($statusMock);

        verify($this->refund->getStatus())->notEmpty();
        verify($this->refund->getStatus())->isInstanceOf(Status::class);
        verify($this->refund->getStatus())->equals($statusMock);
    }

    /**
     * @return void
     */
    public function testItCanAddAProduct(): void
    {
        $productMock = $this->tester->grabService('modelManager')->get('Product');
        expect($this->refund->addProduct($productMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanAddAProduct
     *
     * @return void
     */
    public function testItCanSetProducts(): void
    {
        $productsMock = $this->tester->grabService('modelManager')->get('Products');
        verify($this->refund->setProducts($productsMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetProducts
     *
     * @return void
     */
    public function testItCanGetProducts(): void
    {
        /** @var Products $productsMock */
        $productsMock = $this->tester->grabService('modelManager')->get('Products');
        $this->refund->setProducts($productsMock);
        verify($this->refund->getProducts())->isInstanceOf(Products::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAReason(): void
    {
        expect($this->refund->setReason('Some reason why'))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAReason
     *
     * @return void
     */
    public function testItCanGetAReason(): void
    {
        $this->refund->setReason('Some reason why');

        verify($this->refund->getReason())->string();
        verify($this->refund->getReason())->notEmpty();
        verify($this->refund->getReason())->equals('Some reason why');
    }

    /**
     * @return void
     */
    public function testItCanSetAProcessDate(): void
    {
        $dateTimeMock = Mockery::mock('DateTime');
        expect($this->refund->setProcessDate($dateTimeMock))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAProcessDate
     *
     * @return void
     */
    public function testItCanGetAProcessDate(): void
    {
        $dateTimeMock = Mockery::mock('DateTime');
        $this->refund->setProcessDate($dateTimeMock);

        verify($this->refund->getProcessDate())->notEmpty();
        verify($this->refund->getProcessDate())->isInstanceOf(DateTime::class);
    }
}

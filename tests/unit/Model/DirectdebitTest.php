<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Amount,
    BankAccount,
    Directdebit,
    Status
};

/**
 * Class DirectdebitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class DirectdebitTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Directdebit
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Directdebit();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        expect($this->model->setId('IL-1000-0000-0001'))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $this->model->setId('IL-1000-0000-0001');

        verify($this->model->getId())->string();
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->equals('IL-1000-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentSessionId(): void
    {
        $this->tester->assertObjectHasMethod('setPaymentSessionId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPaymentSessionId', $this->model);

        expect($this->model->setPaymentSessionId('100000000'))->isInstanceOf(Directdebit::class);
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

        expect($this->model->setAmount(new Amount()))->isInstanceOf(Directdebit::class);
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
    public function testItCanSetADescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        expect($this->model->setDescription('Test'))->isInstanceOf(Directdebit::class);
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

        $this->model->setDescription('Test');

        verify($this->model->getDescription())->string();
        verify($this->model->getDescription())->notEmpty();
        verify($this->model->getDescription())->equals('Test');
    }

    /**
     * @return void
     */
    public function testItCanSetABankAccount(): void
    {
        $this->tester->assertObjectHasMethod('setBankAccount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setBankAccount', $this->model);

        expect($this->model->setBankAccount(new BankAccount()))->isInstanceOf(Directdebit::class);
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

        $this->model->setBankAccount(new BankAccount());

        verify($this->model->getBankAccount())->notEmpty();
        verify($this->model->getBankAccount())->isInstanceOf(BankAccount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAStatus(): void
    {
        $this->tester->assertObjectHasMethod('setStatus', $this->model);
        $this->tester->assertObjectMethodIsPublic('setStatus', $this->model);

        expect($this->model->setStatus(new Status()))->isInstanceOf(Directdebit::class);
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

        $this->model->setStatus(new Status());

        verify($this->model->getStatus())->notEmpty();
        verify($this->model->getStatus())->isInstanceOf(Status::class);
    }

    /**
     * @return void
     */
    public function testItCanSetADeclinedStatus(): void
    {
        $this->tester->assertObjectHasMethod('setDeclined', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDeclined', $this->model);

        expect($this->model->setDeclined(new Status()))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetADeclinedStatus
     *
     * @return void
     */
    public function testItCanGetADeclinedStatus(): void
    {
        $this->tester->assertObjectHasMethod('getDeclined', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDeclined', $this->model);

        $this->model->setDeclined(new Status());

        verify($this->model->getDeclined())->notEmpty();
        verify($this->model->getDeclined())->isInstanceOf(Status::class);
    }
}

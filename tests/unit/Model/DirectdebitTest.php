<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{Amount, BankAccount, ModelInterface, Directdebit, Status};
use JsonSerializable, Exception;

/**
 * Class DirectdebitTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class DirectdebitTest extends UnitTest
{
    /**
     * @var Directdebit
     */
    protected $directdebit;

    public function _before(): void
    {
        $this->directdebit = new Directdebit();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->directdebit)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->directdebit)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->directdebit->setId('IL-1000-0000-0001'))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->directdebit->setId('IL-1000-0000-0001');

        verify($this->directdebit->getId())->string();
        verify($this->directdebit->getId())->notEmpty();
        verify($this->directdebit->getId())->equals('IL-1000-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentSessionId(): void
    {
        expect($this->directdebit->setPaymentSessionId('100000000'))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetAPaymentSessionId
     *
     * @return void
     */
    public function testItCanGetAPaymentSessionId(): void
    {
        $this->directdebit->setPaymentSessionId('100000000');

        verify($this->directdebit->getPaymentSessionId())->string();
        verify($this->directdebit->getPaymentSessionId())->notEmpty();
        verify($this->directdebit->getPaymentSessionId())->equals('100000000');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->directdebit->setAmount(new Amount()))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->directdebit->setAmount(new Amount());

        verify($this->directdebit->getAmount())->notEmpty();
        verify($this->directdebit->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->directdebit->setDescription('Test'))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->directdebit->setDescription('Test');

        verify($this->directdebit->getDescription())->string();
        verify($this->directdebit->getDescription())->notEmpty();
        verify($this->directdebit->getDescription())->equals('Test');
    }

    /**
     * @return void
     */
    public function testItCanSetABankAccount(): void
    {
        expect($this->directdebit->setBankAccount(new BankAccount()))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetABankAccount
     *
     * @return void
     */
    public function testItCanGetABankAccount(): void
    {
        $this->directdebit->setBankAccount(new BankAccount());

        verify($this->directdebit->getBankAccount())->notEmpty();
        verify($this->directdebit->getBankAccount())->isInstanceOf(BankAccount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAStatus(): void
    {
        expect($this->directdebit->setStatus(new Status()))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetAStatus
     *
     * @return void
     */
    public function testItCanGetAStatus(): void
    {
        $this->directdebit->setStatus(new Status());

        verify($this->directdebit->getStatus())->notEmpty();
        verify($this->directdebit->getStatus())->isInstanceOf(Status::class);
    }

    /**
     * @return void
     */
    public function testItCanSetADeclinedStatus(): void
    {
        expect($this->directdebit->setDeclined(new Status()))->isInstanceOf(Directdebit::class);
    }

    /**
     * @depends testItCanSetADeclinedStatus
     *
     * @return void
     */
    public function testItCanGetADeclinedStatus(): void
    {
        $this->directdebit->setDeclined(new Status());

        verify($this->directdebit->getDeclined())->notEmpty();
        verify($this->directdebit->getDeclined())->isInstanceOf(Status::class);
    }
}

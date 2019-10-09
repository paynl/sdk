<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    BankAccount
};
use JsonSerializable;

/**
 * Class BankAccountTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class BankAccountTest extends UnitTest
{
    /**
     * @var BankAccount
     */
    protected $bankAccount;

    public function _before(): void
    {
        $this->bankAccount = new BankAccount();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->bankAccount)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->bankAccount)->isInstanceOf(JsonSerializable::class);

        verify($this->bankAccount->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetABank(): void
    {
        expect($this->bankAccount->setBank('Rabobank'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetABank
     *
     * @return void
     */
    public function testItCanGetABank(): void
    {
        $this->bankAccount->setBank('Rabobank');

        verify($this->bankAccount->getBank())->string();
        verify($this->bankAccount->getBank())->notEmpty();
        verify($this->bankAccount->getBank())->equals('Rabobank');
    }

    /**
     * @return void
     */
    public function testItCanSetAnIban(): void
    {
        expect($this->bankAccount->setIban('NL00RABO0000000000'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAnIban
     *
     * @return void
     */
    public function testItCanGetAnIban(): void
    {
        $this->bankAccount->setIban('NL00RABO0000000000');

        verify($this->bankAccount->getIban())->string();
        verify($this->bankAccount->getIban())->notEmpty();
        verify($this->bankAccount->getIban())->equals('NL00RABO0000000000');
    }

    /**
     * @return void
     */
    public function testItCanSetABic(): void
    {
        expect($this->bankAccount->setBic('RABONL2U'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetABic
     *
     * @return void
     */
    public function testItCanGetABic(): void
    {
        $this->bankAccount->setBic('RABONL2U');

        verify($this->bankAccount->getBic())->string();
        verify($this->bankAccount->getBic())->notEmpty();
        verify($this->bankAccount->getBic())->equals('RABONL2U');
    }

    /**
     * @return void
     */
    public function testItCanSetAnOwner(): void
    {
        expect($this->bankAccount->setOwner('The Republic'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAnOwner
     *
     * @return void
     */
    public function testItCanGetAnOwner(): void
    {
        $this->bankAccount->setOwner('The Republic');

        verify($this->bankAccount->getOwner())->string();
        verify($this->bankAccount->getOwner())->notEmpty();
        verify($this->bankAccount->getOwner())->equals('The Republic');
    }

    /**
     * @return void
     */
    public function testItCanSetAReturnUrl(): void
    {
        expect($this->bankAccount->setReturnUrl('https://www.pay.nl'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAReturnUrl
     *
     * @return void
     */
    public function testItCanGetAReturnUrl(): void
    {
        $this->bankAccount->setReturnUrl('https://www.pay.nl');

        verify($this->bankAccount->getReturnUrl())->string();
        verify($this->bankAccount->getReturnUrl())->notEmpty();
        verify($this->bankAccount->getReturnUrl())->equals('https://www.pay.nl');
    }
}

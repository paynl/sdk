<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\BankAccount;

/**
 * Class BankAccountTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class BankAccountTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->shouldItBeJsonSerializable = true;
        $this->model = new BankAccount();
    }

    /**
     * @return void
     */
    public function testItCanSetABank(): void
    {
        expect($this->model->setBank('Rabobank'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetABank
     *
     * @return void
     */
    public function testItCanGetABank(): void
    {
        $this->model->setBank('Rabobank');

        verify($this->model->getBank())->string();
        verify($this->model->getBank())->notEmpty();
        verify($this->model->getBank())->equals('Rabobank');
    }

    /**
     * @return void
     */
    public function testItCanSetAnIban(): void
    {
        expect($this->model->setIban('NL00RABO0000000000'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAnIban
     *
     * @return void
     */
    public function testItCanGetAnIban(): void
    {
        $this->model->setIban('NL00RABO0000000000');

        verify($this->model->getIban())->string();
        verify($this->model->getIban())->notEmpty();
        verify($this->model->getIban())->equals('NL00RABO0000000000');
    }

    /**
     * @return void
     */
    public function testItCanSetABic(): void
    {
        expect($this->model->setBic('RABONL2U'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetABic
     *
     * @return void
     */
    public function testItCanGetABic(): void
    {
        $this->model->setBic('RABONL2U');

        verify($this->model->getBic())->string();
        verify($this->model->getBic())->notEmpty();
        verify($this->model->getBic())->equals('RABONL2U');
    }

    /**
     * @return void
     */
    public function testItCanSetAnOwner(): void
    {
        expect($this->model->setOwner('The Republic'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAnOwner
     *
     * @return void
     */
    public function testItCanGetAnOwner(): void
    {
        $this->model->setOwner('The Republic');

        verify($this->model->getOwner())->string();
        verify($this->model->getOwner())->notEmpty();
        verify($this->model->getOwner())->equals('The Republic');
    }

    /**
     * @return void
     */
    public function testItCanSetAReturnUrl(): void
    {
        expect($this->model->setReturnUrl('https://www.pay.nl'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAReturnUrl
     *
     * @return void
     */
    public function testItCanGetAReturnUrl(): void
    {
        $this->model->setReturnUrl('https://www.pay.nl');

        verify($this->model->getReturnUrl())->string();
        verify($this->model->getReturnUrl())->notEmpty();
        verify($this->model->getReturnUrl())->equals('https://www.pay.nl');
    }
}

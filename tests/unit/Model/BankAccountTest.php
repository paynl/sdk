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
     * @var BankAccount
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new BankAccount();
    }

    /**
     * @return void
     */
    public function testItCanSetABank(): void
    {
        $this->tester->assertObjectHasMethod('setBank', $this->model);
        $this->tester->assertObjectMethodIsPublic('setBank', $this->model);

        expect($this->model->setBank('Rabobank'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetABank
     *
     * @return void
     */
    public function testItCanGetABank(): void
    {
        $this->tester->assertObjectHasMethod('getBank', $this->model);
        $this->tester->assertObjectMethodIsPublic('getBank', $this->model);

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
        $this->tester->assertObjectHasMethod('setIban', $this->model);
        $this->tester->assertObjectMethodIsPublic('setIban', $this->model);

        expect($this->model->setIban('NL00RABO0000000000'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAnIban
     *
     * @return void
     */
    public function testItCanGetAnIban(): void
    {
        $this->tester->assertObjectHasMethod('getIban', $this->model);
        $this->tester->assertObjectMethodIsPublic('getIban', $this->model);

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
        $this->tester->assertObjectHasMethod('setBic', $this->model);
        $this->tester->assertObjectMethodIsPublic('setBic', $this->model);

        expect($this->model->setBic('RABONL2U'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetABic
     *
     * @return void
     */
    public function testItCanGetABic(): void
    {
        $this->tester->assertObjectHasMethod('getBic', $this->model);
        $this->tester->assertObjectMethodIsPublic('getBic', $this->model);

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
        $this->tester->assertObjectHasMethod('setOwner', $this->model);
        $this->tester->assertObjectMethodIsPublic('setOwner', $this->model);

        expect($this->model->setOwner('The Republic'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAnOwner
     *
     * @return void
     */
    public function testItCanGetAnOwner(): void
    {
        $this->tester->assertObjectHasMethod('getOwner', $this->model);
        $this->tester->assertObjectMethodIsPublic('getOwner', $this->model);

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
        $this->tester->assertObjectHasMethod('setReturnUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('setReturnUrl', $this->model);

        expect($this->model->setReturnUrl('https://www.pay.nl'))->isInstanceOf(BankAccount::class);
    }

    /**
     * @depends testItCanSetAReturnUrl
     *
     * @return void
     */
    public function testItCanGetAReturnUrl(): void
    {
        $this->tester->assertObjectHasMethod('getReturnUrl', $this->model);
        $this->tester->assertObjectMethodIsPublic('getReturnUrl', $this->model);

        $this->model->setReturnUrl('https://www.pay.nl');

        verify($this->model->getReturnUrl())->string();
        verify($this->model->getReturnUrl())->notEmpty();
        verify($this->model->getReturnUrl())->equals('https://www.pay.nl');
    }
}

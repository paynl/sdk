<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    ContactMethods,
    Member\LinksAwareTrait,
    Address,
    BankAccount,
    ContactMethod,
    Merchant,
    Trademark,
    Trademarks
};
use Mockery;
use PayNL\Sdk\Common\DateTime;

/**
 * Class MerchantTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class MerchantTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Merchant
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Merchant();
    }

    /**
     * @return void
     */
    public function testItHasLinksTrait(): void
    {
        $this->tester->assertObjectUsesTrait($this->model, LinksAwareTrait::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        expect($this->model->setId('M-1000-0001'))->isInstanceOf(Merchant::class);
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

        $this->model->setId('M-1000-0001');

        verify($this->model->getId())->string();
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->equals('M-1000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('D. Duck'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getName', $this->model);

        $this->model->setName('D. Duck');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('D. Duck');
    }

    /**
     * @return void
     */
    public function testItCanSetACoc(): void
    {
        $this->tester->assertObjectHasMethod('setCoc', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCoc', $this->model);

        expect($this->model->setCoc('1000000'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetACoc
     *
     * @return void
     */
    public function testItCanGetACoc(): void
    {
        $this->tester->assertObjectHasMethod('getCoc', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCoc', $this->model);

        $this->model->setCoc('1000000');

        verify($this->model->getCoc())->string();
        verify($this->model->getCoc())->notEmpty();
        verify($this->model->getCoc())->equals('1000000');
    }

    /**
     * @return void
     */
    public function testItCanSetAVat(): void
    {
        $this->tester->assertObjectHasMethod('setVat', $this->model);
        $this->tester->assertObjectMethodIsPublic('setVat', $this->model);

        expect($this->model->setVat('NL100000000B01'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAVat
     *
     * @return void
     */
    public function testItCanGetAVat(): void
    {
        $this->tester->assertObjectHasMethod('getVat', $this->model);
        $this->tester->assertObjectMethodIsPublic('getVat', $this->model);

        $this->model->setVat('NL100000000B01');

        verify($this->model->getVat())->string();
        verify($this->model->getVat())->notEmpty();
        verify($this->model->getVat())->equals('NL100000000B01');
    }

    /**
     * @return void
     */
    public function testItCanSetAWebsite(): void
    {
        $this->tester->assertObjectHasMethod('setWebsite', $this->model);
        $this->tester->assertObjectMethodIsPublic('setWebsite', $this->model);

        expect($this->model->setWebsite('https://www.pay.nl'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAWebsite
     *
     * @return void
     */
    public function testItCanGetAWebsite(): void
    {
        $this->tester->assertObjectHasMethod('getWebsite', $this->model);
        $this->tester->assertObjectMethodIsPublic('getWebsite', $this->model);

        $this->model->setWebsite('https://www.pay.nl');

        verify($this->model->getWebsite())->string();
        verify($this->model->getWebsite())->notEmpty();
        verify($this->model->getWebsite())->equals('https://www.pay.nl');
    }

    /**
     * @return void
     */
    public function testItCanSetABankAccount(): void
    {
        $this->tester->assertObjectHasMethod('setBankAccount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setBankAccount', $this->model);

        expect($this->model->setBankAccount(new BankAccount()))->isInstanceOf(Merchant::class);
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
    public function testItCanSetAPostalAddress(): void
    {
        $this->tester->assertObjectHasMethod('setPostalAddress', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPostalAddress', $this->model);

        expect($this->model->setPostalAddress(new Address()))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAPostalAddress
     *
     * @return void
     */
    public function testItCanGetAPostalAddress(): void
    {
        $this->tester->assertObjectHasMethod('getPostalAddress', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPostalAddress', $this->model);

        verify($this->model->getPostalAddress())->isInstanceOf(Address::class);

        $this->model->setPostalAddress(new Address());

        verify($this->model->getPostalAddress())->notEmpty();
        verify($this->model->getPostalAddress())->isInstanceOf(Address::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAVisitAddress(): void
    {
        $this->tester->assertObjectHasMethod('setVisitAddress', $this->model);
        $this->tester->assertObjectMethodIsPublic('setVisitAddress', $this->model);

        $address = $this->tester->grabService('modelManager')->get('Address');
        verify($this->model->setVisitAddress($address))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAVisitAddress
     *
     * @return void
     */
    public function testItCanGetAVisitAddress(): void
    {
        $this->tester->assertObjectHasMethod('getVisitAddress', $this->model);
        $this->tester->assertObjectMethodIsPublic('getVisitAddress', $this->model);

        verify($this->model->getVisitAddress())->isInstanceOf(Address::class);

        $address = $this->tester->grabService('modelManager')->get('Address');
        $this->model->setVisitAddress($address);

        verify($this->model->getVisitAddress())->notEmpty();
        verify($this->model->getVisitAddress())->isInstanceOf(Address::class);
    }

    /**
     * @return void
     */
    public function testItCanAddATrademark(): void
    {
        $this->tester->assertObjectHasMethod('addTrademark', $this->model);
        $this->tester->assertObjectMethodIsPublic('addTrademark', $this->model);

        $trademark = $this->tester->grabService('modelManager')->get('Trademark');
        $this->model->addTrademark($trademark);
    }

    /**
     * @return Trademarks
     */
    private function getTrademarks(): Trademarks
    {
        /** @var Trademarks $trademarks */
        $trademarks = $this->tester->grabService('modelManager')->get('Trademarks');

        /** @var Trademark $trademark */
        $trademark = $this->tester->grabService('modelManager')->get('Trademark');
        $trademarks->add($trademark);

        return $trademarks;
    }

    /**
     * @depends testItCanAddATrademark
     *
     * @return void
     */
    public function testItCanSetTrademarks(): void
    {
        $this->tester->assertObjectHasMethod('setTrademarks', $this->model);
        $this->tester->assertObjectMethodIsPublic('setTrademarks', $this->model);

        expect($this->model->setTrademarks($this->getTrademarks()))
            ->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetTrademarks
     *
     * @return void
     */
    public function testItCanGetTrademarks(): void
    {
        $this->tester->assertObjectHasMethod('getTrademarks', $this->model);
        $this->tester->assertObjectMethodIsPublic('getTrademarks', $this->model);

        $this->model->setTrademarks($this->getTrademarks());
        verify($this->model->getTrademarks())->isInstanceOf(Trademarks::class);
    }

    /**
     * @return void
     */
    public function testItCanAddAContactMethod(): void
    {
        $this->tester->assertObjectHasMethod('addContactMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('addContactMethod', $this->model);

        $contactMethod = $this->tester->grabService('modelManager')->get('ContactMethod');
        verify($this->model->addContactMethod($contactMethod))->isInstanceOf(Merchant::class);
    }

    /**
     * @return ContactMethods
     */
    private function getContactMethods(): ContactMethods
    {
        /** @var ContactMethods $contactMethods */
        $contactMethods = $this->tester->grabService('modelManager')->get('ContactMethods');
        /** @var ContactMethod $contactMethod */
        $contactMethod = $this->tester->grabService('modelManager')->get('ContactMethod');
        $contactMethods->add($contactMethod);

        return $contactMethods;
    }

    /**
     * @depends testItCanAddAContactMethod
     *
     * @return void
     */
    public function testItCanSetContactMethods(): void
    {
        $this->tester->assertObjectHasMethod('setContactMethods', $this->model);
        $this->tester->assertObjectMethodIsPublic('setContactMethods', $this->model);

        verify($this->model->setContactMethods($this->getContactMethods()))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetContactMethods
     *
     * @return void
     */
    public function testItCanGetContactMethods(): void
    {
        $this->tester->assertObjectHasMethod('getContactMethods', $this->model);
        $this->tester->assertObjectMethodIsPublic('getContactMethods', $this->model);

        $this->model->setContactMethods($this->getContactMethods());
        verify($this->model->getContactMethods())->isInstanceOf(ContactMethods::class);
        verify($this->model->getContactMethods())->notEmpty();
        verify($this->model->getContactMethods())->containsOnlyInstancesOf(ContactMethod::class);
    }

    /**
     * @return void
     */
    public function testItCanSetACreatedDatetime(): void
    {
        $this->tester->assertObjectHasMethod('setCreatedAt', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCreatedAt', $this->model);

        $datetimeMock = Mockery::mock(DateTime::class);
        verify($this->model->setCreatedAt($datetimeMock))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetACreatedDatetime
     *
     * @return void
     */
    public function testItCanGetACreatedDatetime(): void
    {
        $this->tester->assertObjectHasMethod('getCreatedAt', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCreatedAt', $this->model);

        $datetimeMock = Mockery::mock(DateTime::class);
        $this->model->setCreatedAt($datetimeMock);

        verify($this->model->getCreatedAt())->notEmpty();
        verify($this->model->getCreatedAt())->isInstanceOf(DateTime::class);
    }
}

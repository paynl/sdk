<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ContactMethods,
    LinksTrait,
    ModelInterface,
    Address,
    BankAccount,
    ContactMethod,
    Merchant,
    Trademark,
    Trademarks
};
use JsonSerializable, Exception;
use Mockery;
use PayNL\Sdk\Common\DateTime;
use UnitTester;

/**
 * Class MerchantTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class MerchantTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @var Merchant
     */
    protected $merchant;

    public function _before(): void
    {
        $this->merchant = new Merchant();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->merchant)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->merchant)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItHasLinksTrait(): void
    {
        verify(in_array(LinksTrait::class, class_uses($this->merchant), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->merchant->setId('M-1000-0001'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->merchant->setId('M-1000-0001');

        verify($this->merchant->getId())->string();
        verify($this->merchant->getId())->notEmpty();
        verify($this->merchant->getId())->equals('M-1000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->merchant->setName('D. Duck'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->merchant->setName('D. Duck');

        verify($this->merchant->getName())->string();
        verify($this->merchant->getName())->notEmpty();
        verify($this->merchant->getName())->equals('D. Duck');
    }

    /**
     * @return void
     */
    public function testItCanSetACoc(): void
    {
        expect($this->merchant->setCoc('1000000'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetACoc
     *
     * @return void
     */
    public function testItCanGetACoc(): void
    {
        $this->merchant->setCoc('1000000');

        verify($this->merchant->getCoc())->string();
        verify($this->merchant->getCoc())->notEmpty();
        verify($this->merchant->getCoc())->equals('1000000');
    }

    /**
     * @return void
     */
    public function testItCanSetAVat(): void
    {
        expect($this->merchant->setVat('NL100000000B01'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAVat
     *
     * @return void
     */
    public function testItCanGetAVat(): void
    {
        $this->merchant->setVat('NL100000000B01');

        verify($this->merchant->getVat())->string();
        verify($this->merchant->getVat())->notEmpty();
        verify($this->merchant->getVat())->equals('NL100000000B01');
    }

    /**
     * @return void
     */
    public function testItCanSetAWebsite(): void
    {
        expect($this->merchant->setWebsite('https://www.pay.nl'))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAWebsite
     *
     * @return void
     */
    public function testItCanGetAWebsite(): void
    {
        $this->merchant->setWebsite('https://www.pay.nl');

        verify($this->merchant->getWebsite())->string();
        verify($this->merchant->getWebsite())->notEmpty();
        verify($this->merchant->getWebsite())->equals('https://www.pay.nl');
    }

    /**
     * @return void
     */
    public function testItCanSetABankAccount(): void
    {
        expect($this->merchant->setBankAccount(new BankAccount()))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetABankAccount
     *
     * @return void
     */
    public function testItCanGetABankAccount(): void
    {
        $this->merchant->setBankAccount(new BankAccount());

        verify($this->merchant->getBankAccount())->notEmpty();
        verify($this->merchant->getBankAccount())->isInstanceOf(BankAccount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAPostalAddress(): void
    {
        expect($this->merchant->setPostalAddress(new Address()))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAPostalAddress
     *
     * @return void
     */
    public function testItCanGetAPostalAddress(): void
    {
        $this->merchant->setPostalAddress(new Address());

        verify($this->merchant->getPostalAddress())->notEmpty();
        verify($this->merchant->getPostalAddress())->isInstanceOf(Address::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAVisitAddress(): void
    {
        $address = $this->tester->grabService('modelManager')->get('Address');
        verify($this->merchant->setVisitAddress($address))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAVisitAddress
     *
     * @return void
     */
    public function testItCanGetAVisitAddress(): void
    {
        $address = $this->tester->grabService('modelManager')->get('Address');
        $this->merchant->setVisitAddress($address);

        verify($this->merchant->getVisitAddress())->notEmpty();
        verify($this->merchant->getVisitAddress())->isInstanceOf(Address::class);
    }

    /**
     * @return void
     */
    public function testItCanAddATrademark(): void
    {
        $trademark = $this->tester->grabService('modelManager')->get('Trademark');
        $this->merchant->addTrademark($trademark);
    }

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
        expect($this->merchant->setTrademarks($this->getTrademarks()))
            ->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetTrademarks
     *
     * @return void
     */
    public function testItCanGetTrademarks(): void
    {
        $this->merchant->setTrademarks($this->getTrademarks());
        verify($this->merchant->getTrademarks())->isInstanceOf(Trademarks::class);
    }

    /**
     * @return void
     */
    public function testItCanAddAContactMethod(): void
    {
        $contactMethod = $this->tester->grabService('modelManager')->get('ContactMethod');
        verify($this->merchant->addContactMethod($contactMethod))->isInstanceOf(Merchant::class);
    }

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
        verify($this->merchant->setContactMethods($this->getContactMethods()))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetContactMethods
     *
     * @return void
     */
    public function testItCanGetContactMethods(): void
    {
        $this->merchant->setContactMethods($this->getContactMethods());
        verify($this->merchant->getContactMethods())->isInstanceOf(ContactMethods::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetACreatedDatetime(): void
    {
        $datetimeMock = Mockery::mock(DateTime::class);
        verify($this->merchant->setCreatedAt($datetimeMock))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetACreatedDatetime
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetACreatedDatetime(): void
    {
        $datetimeMock = Mockery::mock(DateTime::class);
        $this->merchant->setCreatedAt($datetimeMock);

        verify($this->merchant->getCreatedAt())->notEmpty();
        verify($this->merchant->getCreatedAt())->isInstanceOf(DateTime::class);
    }
}

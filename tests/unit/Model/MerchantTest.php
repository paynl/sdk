<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Links,
    Address,
    BankAccount,
    ContactMethod,
    Merchant,
    Trademark
};
use JsonSerializable, TypeError, stdClass, Exception;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Hydrator\Links as LinksHydrator;

/**
 * Class MerchantTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class MerchantTest extends UnitTest
{
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
    public function testItCanSetLinks(): void
    {
        verify(method_exists($this->merchant, 'setLinks'))->true();
        verify($this->merchant->setLinks(new Links()))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->merchant, 'getLinks'))->true();

        $this->merchant->setLinks(
            (new LinksHydrator())->hydrate([
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'http://some.url.com',
                ],
            ], new Links())
        );

        verify($this->merchant->getLinks())->isInstanceOf(Links::class);
        verify($this->merchant->getLinks())->count(1);
        verify($this->merchant->getLinks())->hasKey('self');
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
        expect($this->merchant->setVisitAddress(new Address()))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetAVisitAddress
     *
     * @return void
     */
    public function testItCanGetAVisitAddress(): void
    {
        $this->merchant->setVisitAddress(new Address());

        verify($this->merchant->getVisitAddress())->notEmpty();
        verify($this->merchant->getVisitAddress())->isInstanceOf(Address::class);
    }

    /**
     * @return void
     */
    public function testItCanAddATrademark(): void
    {
        $this->merchant->addTrademark(new Trademark());
    }

    /**
     * @depends testItCanAddATrademark
     *
     * @return void
     */
    public function testItCanSetTrademarks(): void
    {
        expect($this->merchant->setTrademarks([
            new Trademark(),
        ]))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetTrademarks
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenSettingTrademarks(): void
    {
        $this->expectException(TypeError::class);
        $this->merchant->setTrademarks([
            new stdClass()
        ]);
    }

    /**
     * @depends testItCanSetTrademarks
     *
     * @return void
     */
    public function testItCanGetTrademarks(): void
    {
        $this->merchant->setTrademarks([
            new Trademark(),
            new Trademark(),
        ]);

        verify($this->merchant->getTrademarks())->array();
        verify($this->merchant->getTrademarks())->count(2);
        verify($this->merchant->getTrademarks())->containsOnlyInstancesOf(Trademark::class);
    }

    /**
     * @return void
     */
    public function testItCanAddAContactMethod(): void
    {
        $this->merchant->addContactMethod(new ContactMethod());
    }

    /**
     * @depends testItCanAddAContactMethod
     *
     * @return void
     */
    public function testItCanSetContactMethods(): void
    {
        expect($this->merchant->setContactMethods([
            new ContactMethod(),
        ]))->isInstanceOf(Merchant::class);
    }

    /**
     * @depends testItCanSetContactMethods
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenSettingContactMethods(): void
    {
        $this->expectException(TypeError::class);
        $this->merchant->setContactMethods([
            new stdClass()
        ]);
    }

    /**
     * @depends testItCanSetContactMethods
     *
     * @return void
     */
    public function testItCanGetContactMethods(): void
    {
        $this->merchant->setContactMethods([
            new ContactMethod(),
            new ContactMethod(),
        ]);

        verify($this->merchant->getContactMethods())->array();
        verify($this->merchant->getContactMethods())->count(2);
        verify($this->merchant->getContactMethods())->containsOnlyInstancesOf(ContactMethod::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetACreatedDatetime(): void
    {
        expect($this->merchant->setCreatedAt(new DateTime()))->isInstanceOf(Merchant::class);
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
        $this->merchant->setCreatedAt(new DateTime());

        verify($this->merchant->getCreatedAt())->notEmpty();
        verify($this->merchant->getCreatedAt())->isInstanceOf(DateTime::class);
    }
}

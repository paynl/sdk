<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\{
    ModelInterface,
    Amount,
    BankAccount,
    Product,
    Refund,
    Status
};
use JsonSerializable, TypeError, stdClass;

/**
 * Class RefundTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class RefundTest extends UnitTest
{
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

        verify($this->refund->jsonSerialize())->array();
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
        expect($this->refund->setAmount(new Amount()))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->refund->setAmount(new Amount());

        verify($this->refund->getAmount())->notEmpty();
        verify($this->refund->getAmount())->isInstanceOf(Amount::class);
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
        expect($this->refund->setBankAccount(new BankAccount()))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetABankAccount
     *
     * @return void
     */
    public function testItCanGetABankAccount(): void
    {
        $this->refund->setBankAccount(new BankAccount());

        verify($this->refund->getBankAccount())->notEmpty();
        verify($this->refund->getBankAccount())->isInstanceOf(BankAccount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAStatus(): void
    {
        expect($this->refund->setStatus(new Status()))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAStatus
     *
     * @return void
     */
    public function testItCanGetAStatus(): void
    {
        $this->refund->setStatus(new Status());

        verify($this->refund->getStatus())->notEmpty();
        verify($this->refund->getStatus())->isInstanceOf(Status::class);
    }

    /**
     * @return void
     */
    public function testItCanAddAProduct(): void
    {
        expect($this->refund->addProduct(new Product()))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanAddAProduct
     *
     * @return void
     */
    public function testItCanSetProducts(): void
    {
        expect($this->refund->setProducts([]))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetProducts
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenSettingProducts(): void
    {
        $this->expectException(TypeError::class);
        $this->refund->setProducts([
            new stdClass(),
        ]);
    }

    /**
     * @depends testItCanSetProducts
     *
     * @return void
     */
    public function testItCanGetProducts(): void
    {
        $this->refund->setProducts([
            new Product()
        ]);

        verify($this->refund->getProducts())->array();
        verify($this->refund->getProducts())->notEmpty();
        verify($this->refund->getProducts())->count(1);
        verify($this->refund->getProducts())->containsOnlyInstancesOf(Product::class);
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
        expect($this->refund->setProcessDate(DateTime::createFromFormat('Y-m-d', '2019-09-18')))->isInstanceOf(Refund::class);
    }

    /**
     * @depends testItCanSetAProcessDate
     *
     * @return void
     */
    public function testItCanGetAProcessDate(): void
    {
        $this->refund->setProcessDate(DateTime::createFromFormat('Y-m-d', '2019-09-18'));

        verify($this->refund->getProcessDate())->notEmpty();
        verify($this->refund->getProcessDate())->isInstanceOf(DateTime::class);
    }
}

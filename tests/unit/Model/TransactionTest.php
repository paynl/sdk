<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\Address;
use PayNL\Sdk\Model\Amount;
use PayNL\Sdk\Model\Company;
use PayNL\Sdk\Model\Customer;
use PayNL\Sdk\Model\PaymentMethod;
use PayNL\Sdk\Model\Product;
use PayNL\Sdk\Model\Statistics;
use PayNL\Sdk\Model\Status;
use PayNL\Sdk\Model\Transaction;
use PayNL\Sdk\Model\ModelInterface;
use Exception;

/**
 * Class TransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TransactionTest extends UnitTest
{
    /**
     * @var Transaction
     */
    protected $transaction;

    public function _before(): void
    {
        $this->transaction = new Transaction();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->transaction)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->transaction)->isInstanceOf(\JsonSerializable::class);

        verify($this->transaction->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->transaction->setId('T-0000-0001'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->transaction->setId('T-0000-0001');

        verify($this->transaction->getId())->string();
        verify($this->transaction->getId())->notEmpty();
        verify($this->transaction->getId())->equals('T-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetAServiceId(): void
    {
        expect($this->transaction->setServiceId('SL-0000-0001'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAServiceId
     *
     * @return void
     */
    public function testItCanGetAServiceId(): void
    {
        $this->transaction->setServiceId('SL-0000-0001');

        verify($this->transaction->getServiceId())->string();
        verify($this->transaction->getServiceId())->notEmpty();
        verify($this->transaction->getServiceId())->equals('SL-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetASStatus(): void
    {
        expect($this->transaction->setStatus(new Status()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetASStatus
     *
     * @return void
     */
    public function testItCanGetASStatus(): void
    {
        $this->transaction->setStatus(new Status());

        verify($this->transaction->getStatus())->notEmpty();
        verify($this->transaction->getStatus())->isInstanceOf(Status::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAReturnUrl(): void
    {
        expect($this->transaction->setReturnUrl('http://www.pay.nl/return-url'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAReturnUrl
     *
     * @return void
     */
    public function testItCanGetAReturnUrl(): void
    {
        $this->transaction->setReturnUrl('http://www.pay.nl/return-url');

        verify($this->transaction->getReturnUrl())->string();
        verify($this->transaction->getReturnUrl())->notEmpty();
        verify($this->transaction->getReturnUrl())->equals('http://www.pay.nl/return-url');
    }

    // TODO: add exchange URL tests!

    /**
     * @return void
     */
    public function testItCanSetAReference(): void
    {
        expect($this->transaction->setReference('consumer reference'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAReference
     *
     * @return void
     */
    public function testItCanGetAReference(): void
    {
        $this->transaction->setReference('consumer reference');

        verify($this->transaction->getReference())->string();
        verify($this->transaction->getReference())->notEmpty();
        verify($this->transaction->getReference())->equals('consumer reference');
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentMethod(): void
    {
        expect($this->transaction->setPaymentMethod(new PaymentMethod()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAPaymentMethod
     *
     * @return void
     */
    public function testItCanGetAPaymentMethod(): void
    {
        $this->transaction->setPaymentMethod(new PaymentMethod());

        verify($this->transaction->getPaymentMethod())->notEmpty();
        verify($this->transaction->getPaymentMethod())->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->transaction->setDescription('Transaction description'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->transaction->setDescription('Transaction description');

        verify($this->transaction->getDescription())->string();
        verify($this->transaction->getDescription())->notEmpty();
        verify($this->transaction->getDescription())->equals('Transaction description');
    }

    /**
     * @return void
     */
    public function testItCanSetAIssuerUrl(): void
    {
        expect($this->transaction->setIssuerUrl('https://www.pay.nl/pay-link'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAIssuerUrl
     *
     * @return void
     */
    public function testItCanGetAIssuerUrl(): void
    {
        $this->transaction->setIssuerUrl('https://www.pay.nl/pay-link');

        verify($this->transaction->getIssuerUrl())->string();
        verify($this->transaction->getIssuerUrl())->notEmpty();
        verify($this->transaction->getIssuerUrl())->equals('https://www.pay.nl/pay-link');
    }

    /**
     * @return void
     */
    public function testItCanSetAOrderNumber(): void
    {
        expect($this->transaction->setOrderNumber('O1000024'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAOrderNumber
     *
     * @return void
     */
    public function testItCanGetAOrderNumber(): void
    {
        $this->transaction->setOrderNumber('O10000042');

        verify($this->transaction->getOrderNumber())->string();
        verify($this->transaction->getOrderNumber())->notEmpty();
        verify($this->transaction->getOrderNumber())->equals('O10000042');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAInvoiceDate(): void
    {
        expect($this->transaction->setInvoiceDate(DateTime::now()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAInvoiceDate
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAInvoiceDate(): void
    {
        $this->transaction->setInvoiceDate(DateTime::now());

        verify($this->transaction->getInvoiceDate())->notEmpty();
        verify($this->transaction->getInvoiceDate())->isInstanceOf(DateTime::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetADeliveryDate(): void
    {
        expect($this->transaction->setDeliveryDate(DateTime::now()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetADeliveryDate
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetADeliveryDate(): void
    {
        $this->transaction->setDeliveryDate(DateTime::now());

        verify($this->transaction->getDeliveryDate())->notEmpty();
        verify($this->transaction->getDeliveryDate())->isInstanceOf(DateTime::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAAddress(): void
    {
        expect($this->transaction->setAddress(new Address()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAAddress
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAAddress(): void
    {
        $this->transaction->setAddress(new Address());

        verify($this->transaction->getAddress())->notEmpty();
        verify($this->transaction->getAddress())->isInstanceOf(Address::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetABillingAddress(): void
    {
        expect($this->transaction->setBillingAddress(new Address()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetABillingAddress
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetABillingAddress(): void
    {
        $this->transaction->setBillingAddress(new Address());

        verify($this->transaction->getBillingAddress())->notEmpty();
        verify($this->transaction->getBillingAddress())->isInstanceOf(Address::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetACustomer(): void
    {
        expect($this->transaction->setCustomer(new Customer()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetACustomer
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetACustomer(): void
    {
        $this->transaction->setCustomer(new Customer());

        verify($this->transaction->getCustomer())->notEmpty();
        verify($this->transaction->getCustomer())->isInstanceOf(Customer::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetProducts(): void
    {
        expect($this->transaction->setProducts([
            new Product(),
        ]))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetProducts
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetProducts(): void
    {
        $this->transaction->setProducts([
            new Product(),
        ]);

        verify($this->transaction->getProducts())->array();
        verify($this->transaction->getProducts())->notEmpty();
        verify($this->transaction->getProducts())->containsOnlyInstancesOf(Product::class);
        verify($this->transaction->getProducts())->count(1);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        expect($this->transaction->setAmount(new Amount()))->isInstanceOf(Transaction::class);
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
        $this->transaction->setAmount(new Amount());

        verify($this->transaction->getAmount())->notEmpty();
        verify($this->transaction->getAmount())->isInstanceOf(Amount::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAnAmountConverted(): void
    {
        expect($this->transaction->setAmountConverted(new Amount()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAnAmountConverted
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAnAmountConverted(): void
    {
        $this->transaction->setAmountConverted(new Amount());

        verify($this->transaction->getAmountConverted())->notEmpty();
        verify($this->transaction->getAmountConverted())->isInstanceOf(Amount::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAnAmountPaid(): void
    {
        expect($this->transaction->setAmountPaid(new Amount()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAnAmountPaid
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAnAmountPaid(): void
    {
        $this->transaction->setAmountPaid(new Amount());

        verify($this->transaction->getAmountPaid())->notEmpty();
        verify($this->transaction->getAmountPaid())->isInstanceOf(Amount::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAnAmountRefunded(): void
    {
        expect($this->transaction->setAmountRefunded(new Amount()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAnAmountRefunded
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAnAmountRefunded(): void
    {
        $this->transaction->setAmountRefunded(new Amount());

        verify($this->transaction->getAmountRefunded())->notEmpty();
        verify($this->transaction->getAmountRefunded())->isInstanceOf(Amount::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAStatistics(): void
    {
        expect($this->transaction->setStatistics(new Statistics()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAStatistics
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAStatistics(): void
    {
        $this->transaction->setStatistics(new Statistics());

        verify($this->transaction->getStatistics())->notEmpty();
        verify($this->transaction->getStatistics())->isInstanceOf(Statistics::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetACreatedAt(): void
    {
        expect($this->transaction->setCreatedAt(DateTime::now()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetACreatedAt
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetACreatedAt(): void
    {
        $this->transaction->setCreatedAt(DateTime::now());

        verify($this->transaction->getCreatedAt())->notEmpty();
        verify($this->transaction->getCreatedAt())->isInstanceOf(DateTime::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetAExpiresAt(): void
    {
        expect($this->transaction->setExpiresAt(DateTime::now()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAExpiresAt
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetAExpiresAt(): void
    {
        $this->transaction->setExpiresAt(DateTime::now());

        verify($this->transaction->getExpiresAt())->notEmpty();
        verify($this->transaction->getExpiresAt())->isInstanceOf(DateTime::class);
    }

    // TODO: paymentMethod(Sub)Id ????

    /**
     * @return void
     */
    public function testItCanSetTestMode(): void
    {
        expect($this->transaction->setTestMode(1))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetTestMode
     *
     * @return void
     */
    public function testItCanGetTestMode(): void
    {
        $this->transaction->setTestMode(1);

        verify($this->transaction->getTestMode())->int();
        verify($this->transaction->getTestMode())->notEmpty();
        verify($this->transaction->getTestMode())->equals(1);
    }

    /**
     * @return void
     */
    public function testItCanSetATransferType(): void
    {
        expect($this->transaction->setTransferType('type'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetATransferType
     *
     * @return void
     */
    public function testItCanGetATransferType(): void
    {
        $this->transaction->setTransferType('type');

        verify($this->transaction->getTransferType())->string();
        verify($this->transaction->getTransferType())->notEmpty();
        verify($this->transaction->getTransferType())->equals('type');
    }

    /**
     * @return void
     */
    public function testItCanSetATransferValue(): void
    {
        expect($this->transaction->setTransferValue('value'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetATransferValue
     *
     * @return void
     */
    public function testItCanGetATransferValue(): void
    {
        $this->transaction->setTransferValue('value');

        verify($this->transaction->getTransferValue())->string();
        verify($this->transaction->getTransferValue())->notEmpty();
        verify($this->transaction->getTransferValue())->equals('value');
    }

    /**
     * @return void
     */
    public function testItCanSetAnEndUserId(): void
    {
        expect($this->transaction->setEndUserId('E-0000'))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetAnEndUserId
     *
     * @return void
     */
    public function testItCanGetAnEndUserId(): void
    {
        $this->transaction->setEndUserId('E-0000');

        verify($this->transaction->getEndUserId())->string();
        verify($this->transaction->getEndUserId())->notEmpty();
        verify($this->transaction->getEndUserId())->equals('E-0000');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanSetACompany(): void
    {
        expect($this->transaction->setCompany(new Company()))->isInstanceOf(Transaction::class);
    }

    /**
     * @depends testItCanSetACompany
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetACompany(): void
    {
        $this->transaction->setCompany(new Company());

        verify($this->transaction->getCompany())->notEmpty();
        verify($this->transaction->getCompany())->isInstanceOf(Company::class);
    }
}

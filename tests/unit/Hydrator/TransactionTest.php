<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\{
    Transaction as TransactionHydrator,
    Status as StatusHydrator,
    BankAccount as BankAccountHydrator,
    Address as AddressHydrator,
    Customer as CustomerHydrator,
    Product as ProductHydrator,
    Statistics as StatisticsHydrator
};
use PayNL\Sdk\Model\{
    Transaction,
    Status,
    PaymentMethod,
    BankAccount,
    Address,
    Customer,
    Product,
    Amount,
    Statistics,
    Company
};
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;
use PayNL\Sdk\DateTime;

/**
 * Class TransactionTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class TransactionTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new TransactionHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldOnlyAcceptSpecificModel(): void
    {
        $hydrator = new TransactionHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new Transaction()))->isInstanceOf(Transaction::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new TransactionHydrator();
        $transaction = $hydrator->hydrate([
            'id' => 484512854,
            'serviceId' => 'SL-5350-2350',
            'status' => (new StatusHydrator())->hydrate([
                'code'   => 316,
                'name'   => 'processed',
                'date'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
                'reason' => 'Just because...'
            ], new Status()),
            'returnUrl' => 'http://www.pay.nl/return-url',
            'exchangeUrl' => 'https://www.pay.nl/exchange-url',
            'reference' => '',
            'paymentMethod' => (new ClassMethods())->hydrate([
                'id' => 10,
                'name' => 'ideal',
            ], new PaymentMethod()),
            'description' => 'Test description',
            'issuerUrl' => '',
            'orderNumber' => '',
            'invoiceDate' => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'deliveryDate' => '2019-09-11T14:57:16+02:00',
            'address' => (new AddressHydrator())->hydrate([
                'streetName' => 'Mountain Drive',
                'streetNumber' => '1007',
                'zipCode' => '24857',
                'city' => 'Gotham',
                'regionCode' => 'US-NY',
                'countryCode' => 'US',
                'initials' => 'B',
                'lastName' => 'Wayne'
            ], new Address()),
            'billingAddress' => (new AddressHydrator())->hydrate([
                'streetName' => 'Mountain Drive',
                'streetNumber' => '1007',
                'zipCode' => '24857',
                'city' => 'Gotham',
                'regionCode' => 'US-NY',
                'countryCode' => 'US',
                'initials' => 'B',
                'lastName' => 'Wayne'
            ], new Address()),
            'customer' => (new CustomerHydrator())->hydrate([
                'initials' => 'B',
                'firstName' => 'Bruce',
                'lastName' => 'Wayne',
                'ip' => '10.0.0.1',
                'birthDate' => '1970-01-01T01:00:00+02:00',
                'gender' => 'M',
                'phone' => '612121212',
                'email' => 'b.wayne@wayne-enterprises.com',
                'trustLevel' => '-5',
                'bankAccount' => (new BankAccountHydrator())->hydrate([
                    'iban' => 'NL91ABNA0417164300',
                    'bic' => 'INGBNL2A',
                    'owner' => 'Bruce Wayne'
                ], new BankAccount()),
                'reference' => '123456789',
                'language' => 'NL',
            ], new Customer()),
            'products' => [
                (new ProductHydrator())->hydrate([
                    'id' => 'P-1000-00021',
                    'description' => 'Tumbler',
                    'price' => (new ClassMethods())->hydrate([
                        'amount' => '2500000',
                        'currency' => 'USD'
                    ], new Amount()),
                    'quantity' => 1,
                    'vat' => 0
                ], new Product())
            ],
            'amount' => (new ClassMethods())->hydrate([
                'amount'   => 34500,
                'currency' => 'USD'
            ], new Amount()),
            'amountConverted' => (new ClassMethods())->hydrate([
                'amount'   => 28000,
                'currency' => 'EUR'
            ], new Amount()),
            'amountPaid' => (new ClassMethods())->hydrate([
                'amount'   => 28000,
                'currency' => 'EUR'
            ], new Amount()),
            'amountRefunded' => (new ClassMethods())->hydrate([
                'amount'   => 0,
                'currency' => 'EUR'
            ], new Amount()),
            'statistics' => (new StatisticsHydrator())->hydrate([
                'promoterId' => 0,
                'info' => 'This is information',
                'tool' => 'I use this tool',
                'extra1' => '',
                'extra2' => '',
                'extra3' => '',
                'transferData' => [
                    'dataaaaa'
                ]
            ], new Statistics()),
            'createdAt' => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'expiresAt' => '2019-12-31T00:00:00+02:00',
            'testMode' => 0,
            'transferType' => 'merchant',
            'transferValue' => 'M-3421-2120',
            'endUserId' => '0',
            'company' => (new ClassMethods())->hydrate([
                'name' => 'Wayne Enterprises Inc.',
                'coc' => '12345678',
                'vat' => '24456789B01',
                'countryCode' => 'US'
            ], new Company()),
        ], new Transaction());

        expect($transaction->getId())->string();
        expect($transaction->getServiceId())->string();
        expect($transaction->getStatus())->isInstanceOf(Status::class);
        expect($transaction->getReturnUrl())->string();
        expect($transaction->getExchangeUrl())->string();
        expect($transaction->getReference())->string();
        expect($transaction->getPaymentMethod())->isInstanceOf(PaymentMethod::class);
        expect($transaction->getDescription())->string();
        expect($transaction->getIssuerUrl())->string();
        expect($transaction->getOrderNumber())->string();
        expect($transaction->getInvoiceDate())->isInstanceOf(DateTime::class);
        expect($transaction->getDeliveryDate())->isInstanceOf(DateTime::class);
        expect($transaction->getAddress())->isInstanceOf(Address::class);
        expect($transaction->getBillingAddress())->isInstanceOf(Address::class);
        expect($transaction->getCustomer())->isInstanceOf(Customer::class);
        expect($transaction->getProducts())->array();
        expect($transaction->getProducts())->containsOnlyInstancesOf(Product::class);
        expect($transaction->getProducts())->count(1);
        expect($transaction->getAmount())->isInstanceOf(Amount::class);
        expect($transaction->getAmountConverted())->isInstanceOf(Amount::class);
        expect($transaction->getAmountPaid())->isInstanceOf(Amount::class);
        expect($transaction->getAmountRefunded())->isInstanceOf(Amount::class);
        expect($transaction->getStatistics())->isInstanceOf(Statistics::class);
        expect($transaction->getCreatedAt())->isInstanceOf(DateTime::class);
        expect($transaction->getExpiresAt())->isInstanceOf(DateTime::class);
        expect($transaction->getTestMode())->int();
        expect($transaction->getTransferType())->string();
        expect($transaction->getTransferValue())->string();
        expect($transaction->getEndUserId())->string();
        expect($transaction->getCompany())->isInstanceOf(Company::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new TransactionHydrator();
        $transaction = $hydrator->hydrate([
            'id' => 484512854,
            'serviceId' => 'SL-5350-2350',
            'status' => (new StatusHydrator())->hydrate([
                'code'   => 316,
                'name'   => 'processed',
                'date'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
                'reason' => 'Just because...'
            ], new Status()),
            'returnUrl' => 'https://www.pay.nl/return-url',
            'exchangeUrl' => 'https://www.pay.nl/exchange-url',
            'reference' => '',
            'paymentMethod' => (new ClassMethods())->hydrate([
                'id' => 10,
                'name' => 'ideal',
            ], new PaymentMethod()),
            'description' => 'Test description',
            'issuerUrl' => '',
            'orderNumber' => '',
            'invoiceDate' => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'deliveryDate' => '2019-09-11T14:57:16+02:00',
            'address' => (new AddressHydrator())->hydrate([
                'streetName' => 'Mountain Drive',
                'streetNumber' => '1007',
                'zipCode' => '24857',
                'city' => 'Gotham',
                'regionCode' => 'US-NY',
                'countryCode' => 'US',
                'initials' => 'B',
                'lastName' => 'Wayne'
            ], new Address()),
            'billingAddress' => (new AddressHydrator())->hydrate([
                'streetName' => 'Mountain Drive',
                'streetNumber' => '1007',
                'zipCode' => '24857',
                'city' => 'Gotham',
                'regionCode' => 'US-NY',
                'countryCode' => 'US',
                'initials' => 'B',
                'lastName' => 'Wayne'
            ], new Address()),
            'customer' => (new CustomerHydrator())->hydrate([
                'initials' => 'B',
                'firstName' => 'Bruce',
                'lastName' => 'Wayne',
                'ip' => '10.0.0.1',
                'birthDate' => '1970-01-01T01:00:00+02:00',
                'gender' => 'M',
                'phone' => '612121212',
                'email' => 'b.wayne@wayne-enterprises.com',
                'trustLevel' => '-5',
                'bankAccount' => (new BankAccountHydrator())->hydrate([
                    'iban' => 'NL91ABNA0417164300',
                    'bic' => 'INGBNL2A',
                    'owner' => 'Bruce Wayne'
                ], new BankAccount()),
                'reference' => '123456789',
                'language' => 'NL',
            ], new Customer()),
            'products' => [
                (new ProductHydrator())->hydrate([
                    'id' => 'P-1000-00021',
                    'description' => 'Tumbler',
                    'price' => (new ClassMethods())->hydrate([
                        'amount' => '2500000',
                        'currency' => 'USD'
                    ], new Amount()),
                    'quantity' => 1,
                    'vat' => 0
                ], new Product())
            ],
            'amount' => (new ClassMethods())->hydrate([
                'amount'   => 34500,
                'currency' => 'USD'
            ], new Amount()),
            'amountConverted' => (new ClassMethods())->hydrate([
                'amount'   => 28000,
                'currency' => 'EUR'
            ], new Amount()),
            'amountPaid' => (new ClassMethods())->hydrate([
                'amount'   => 28000,
                'currency' => 'EUR'
            ], new Amount()),
            'amountRefunded' => (new ClassMethods())->hydrate([
                'amount'   => 0,
                'currency' => 'EUR'
            ], new Amount()),
            'statistics' => (new StatisticsHydrator())->hydrate([
                'promoterId' => 0,
                'info' => 'This is information',
                'tool' => 'I use this tool',
                'extra1' => '',
                'extra2' => '',
                'extra3' => '',
                'transferData' => [
                    'dataaaaa'
                ]
            ], new Statistics()),
            'createdAt' => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'expiresAt' => '2019-12-31T00:00:00+02:00',
            'testMode' => 0,
            'transferType' => 'merchant',
            'transferValue' => 'M-3421-2120',
            'endUserId' => 0,
            'company' => (new ClassMethods())->hydrate([
                'name' => 'Wayne Enterprises Inc.',
                'coc' => '12345678',
                'vat' => '24456789B01',
                'countryCode' => 'US'
            ], new Company()),
        ], new Transaction());

        $data = $hydrator->extract($transaction);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('serviceId');
        verify($data)->hasKey('status');
        verify($data)->hasKey('returnUrl');
        verify($data)->hasKey('exchangeUrl');
        verify($data)->hasKey('reference');
        verify($data)->hasKey('paymentMethod');
        verify($data)->hasKey('description');
        verify($data)->hasKey('issuerUrl');
        verify($data)->hasKey('orderNumber');
        verify($data)->hasKey('invoiceDate');
        verify($data)->hasKey('deliveryDate');
        verify($data)->hasKey('address');
        verify($data)->hasKey('billingAddress');
        verify($data)->hasKey('customer');
        verify($data)->hasKey('products');
        verify($data)->hasKey('amount');
        verify($data)->hasKey('amountConverted');
        verify($data)->hasKey('amountPaid');
        verify($data)->hasKey('amountRefunded');
        verify($data)->hasKey('statistics');
        verify($data)->hasKey('createdAt');
        verify($data)->hasKey('expiresAt');
        verify($data)->hasKey('testMode');
        verify($data)->hasKey('transferType');
        verify($data)->hasKey('transferValue');
        verify($data)->hasKey('endUserId');
        verify($data)->hasKey('company');

        expect($data['id'])->string();
        expect($data['serviceId'])->string();
        expect($data['status'])->isInstanceOf(Status::class);
        expect($data['returnUrl'])->string();
        expect($transaction->getExchangeUrl())->string();
        expect($data['reference'])->string();
        expect($data['paymentMethod'])->isInstanceOf(PaymentMethod::class);
        expect($data['description'])->string();
        expect($data['issuerUrl'])->string();
        expect($data['orderNumber'])->string();
        expect($data['invoiceDate'])->isInstanceOf(DateTime::class);
        expect($data['deliveryDate'])->isInstanceOf(DateTime::class);
        expect($data['address'])->isInstanceOf(Address::class);
        expect($data['billingAddress'])->isInstanceOf(Address::class);
        expect($data['customer'])->isInstanceOf(Customer::class);
        expect($data['products'])->array();
        expect($data['products'])->containsOnlyInstancesOf(Product::class);
        expect($data['products'])->count(1);
        expect($data['amount'])->isInstanceOf(Amount::class);
        expect($data['amountConverted'])->isInstanceOf(Amount::class);
        expect($data['amountPaid'])->isInstanceOf(Amount::class);
        expect($data['amountRefunded'])->isInstanceOf(Amount::class);
        expect($data['statistics'])->isInstanceOf(Statistics::class);
        expect($data['createdAt'])->isInstanceOf(DateTime::class);
        expect($data['expiresAt'])->isInstanceOf(DateTime::class);
        expect($data['testMode'])->int();
        expect($data['transferType'])->string();
        expect($data['transferValue'])->string();
        expect($data['endUserId'])->string();
        expect($data['company'])->isInstanceOf(Company::class);
    }
}

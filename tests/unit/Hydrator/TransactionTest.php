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
    TransactionStatus,
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
use Exception;

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
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldAcceptATransactionModel(): void
    {
        $hydrator = new TransactionHydrator();
        expect($hydrator->hydrate([], new Transaction()))->isInstanceOf(Transaction::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new TransactionHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new TransactionHydrator();
        $transaction = $hydrator->hydrate([
            'id' => 484512854,
            'serviceId' => 'SL-1000-0001',
            'status' => [
                'code'   => TransactionStatus::STATUS_PROCESSED,
                'name'   => 'processed',
                'date'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
                'reason' => 'Just because...'
            ],
            'returnUrl' => 'https://www.pay.nl/return-url',
            'exchangeUrl' => 'https://www.pay.nl/exchange-url',
            'reference' => '',
            'paymentMethod' => [
                'id' => 10,
                'name' => 'ideal',
            ],
            'description' => 'Test description',
            'issuerUrl' => '',
            'orderNumber' => '',
            'invoiceDate' => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'deliveryDate' => '2019-09-11T14:57:16+02:00',
            'address' => [
                'streetName' => 'Mountain Drive',
                'streetNumber' => '1007',
                'zipCode' => '24857',
                'city' => 'Gotham',
                'regionCode' => 'US-NY',
                'countryCode' => 'US',
                'initials' => 'B',
                'lastName' => 'Wayne'
            ],
            'billingAddress' => [
                'streetName' => 'Mountain Drive',
                'streetNumber' => '1007',
                'zipCode' => '24857',
                'city' => 'Gotham',
                'regionCode' => 'US-NY',
                'countryCode' => 'US',
                'initials' => 'B',
                'lastName' => 'Wayne'
            ],
            'customer' => [
                'initials' => 'B',
                'firstName' => 'Bruce',
                'lastName' => 'Wayne',
                'ip' => '10.0.0.1',
                'birthDate' => '1970-01-01T01:00:00+02:00',
                'gender' => 'M',
                'phone' => '612121212',
                'email' => 'b.wayne@wayne-enterprises.com',
                'trustLevel' => '-5',
                'bankAccount' => [
                    'iban' => 'NL91ABNA0417164300',
                    'bic' => 'INGBNL2A',
                    'owner' => 'Bruce Wayne'
                ],
                'reference' => '123456789',
                'language' => 'NL',
            ],
            'products' => [
                [
                    'id' => 'P-1000-00021',
                    'description' => 'Tumbler',
                    'price' => [
                        'amount' => '2500000',
                        'currency' => 'USD'
                    ],
                    'quantity' => 1,
                    'vat' => 0
                ]
            ],
            'amount' => [
                'amount'   => 34500,
                'currency' => 'USD'
            ],
            'amountConverted' => [
                'amount'   => 28000,
                'currency' => 'EUR'
            ],
            'amountPaid' => [
                'amount'   => 28000,
                'currency' => 'EUR'
            ],
            'amountRefunded' => [
                'amount'   => 0,
                'currency' => 'EUR'
            ],
            'statistics' => [
                'promoterId' => 0,
                'info' => 'This is information',
                'tool' => 'I use this tool',
                'extra1' => '',
                'extra2' => '',
                'extra3' => '',
                'transferData' => [
                    'dataaaaa'
                ]
            ],
            'createdAt' => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            'expiresAt' => '2019-12-31T00:00:00+02:00',
            'testMode' => 0,
            'transferType' => 'merchant',
            'transferValue' => 'M-1000-1000',
            'endUserId' => '0',
            'company' => [
                'name' => 'Wayne Enterprises Inc.',
//                'coc' => null,
                'vat' => '24456789B01',
                'countryCode' => 'US'
            ],
        ], new Transaction());

        expect($transaction->getId())->string();
        expect($transaction->getId())->equals('484512854');
        expect($transaction->getServiceId())->string();
        expect($transaction->getServiceId())->equals('SL-1000-0001');
        expect($transaction->getStatus())->isInstanceOf(TransactionStatus::class);
        expect($transaction->getReturnUrl())->string();
        expect($transaction->getReturnUrl())->equals('https://www.pay.nl/return-url');
        expect($transaction->getExchangeUrl())->string();
        expect($transaction->getExchangeUrl())->equals('https://www.pay.nl/exchange-url');
        expect($transaction->getMerchantReference())->string();
        expect($transaction->getMerchantReference())->equals('');
        expect($transaction->getPaymentMethod())->isInstanceOf(PaymentMethod::class);
        expect($transaction->getDescription())->string();
        expect($transaction->getDescription())->equals('Test description');
        expect($transaction->getIssuerUrl())->string();
        expect($transaction->getIssuerUrl())->equals('');
        expect($transaction->getOrderNumber())->string();
        expect($transaction->getOrderNumber())->equals('');
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
        expect($transaction->getTestMode())->equals(0);
        expect($transaction->getTransferType())->string();
        expect($transaction->getTransferType())->equals('merchant');
        expect($transaction->getTransferValue())->string();
        expect($transaction->getTransferValue())->equals('M-1000-1000');
        expect($transaction->getEndUserId())->string();
        expect($transaction->getEndUserId())->equals('0');
        expect($transaction->getCompany())->isInstanceOf(Company::class);
        expect($transaction->getCompany()->getCoc())->equals('');
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new TransactionHydrator();
        $transaction = $hydrator->hydrate([
            'id' => 484512854,
            'serviceId' => 'SL-1000-0001',
            'status' => (new StatusHydrator())->hydrate([
                'code'   => TransactionStatus::STATUS_PROCESSED,
                'name'   => 'processed',
                'date'   => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
                'reason' => 'Just because...'
            ], new TransactionStatus()),
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
            'transferValue' => 'M-1000-1000',
            'endUserId' => '0',
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
        expect($data['id'])->equals('484512854');
        expect($data['serviceId'])->string();
        expect($data['serviceId'])->equals('SL-1000-0001');
        expect($data['status'])->isInstanceOf(TransactionStatus::class);
        expect($data['returnUrl'])->string();
        expect($data['returnUrl'])->equals('https://www.pay.nl/return-url');
        expect($data['exchangeUrl'])->string();
        expect($data['exchangeUrl'])->equals('https://www.pay.nl/exchange-url');
        expect($data['reference'])->string();
        expect($data['reference'])->equals('');
        expect($data['paymentMethod'])->isInstanceOf(PaymentMethod::class);
        expect($data['description'])->string();
        expect($data['description'])->equals('Test description');
        expect($data['issuerUrl'])->string();
        expect($data['issuerUrl'])->equals('');
        expect($data['orderNumber'])->string();
        expect($data['orderNumber'])->equals('');
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
        expect($data['testMode'])->equals(0);
        expect($data['transferType'])->string();
        expect($data['transferType'])->equals('merchant');
        expect($data['transferValue'])->string();
        expect($data['transferValue'])->equals('M-1000-1000');
        expect($data['endUserId'])->string();
        expect($data['endUserId'])->equals('0');
        expect($data['company'])->isInstanceOf(Company::class);
    }
}

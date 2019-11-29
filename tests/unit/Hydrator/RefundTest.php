<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\{
    Product as ProductHydrator,
    Refund as RefundHydrator,
    BankAccount as BankAccountHydrator,
    Status as StatusHydrator
};
use PayNL\Sdk\Model\{
    Product,
    Refund,
    BankAccount,
    Amount,
    Status,
    Links
};
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;
use Exception;

/**
 * Class RefundTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class RefundTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new RefundHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldAcceptARefundModel(): void
    {
        $hydrator = new RefundHydrator();
        expect($hydrator->hydrate([], new Refund()))->isInstanceOf(Refund::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new RefundHydrator();

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
        $hydrator = new RefundHydrator();
        $refund = $hydrator->hydrate([
            'paymentSessionId' => '100000000',
            'amount'           => (new ClassMethods())->hydrate([
                'amount'   => 10,
                'currency' => 'EUR',
            ], new Amount()),
            'description'      => 'Refund to Scrooge McDuck',
            'bankAccount'      => (new BankAccountHydrator())->hydrate([
                'number' => 'NL91ABNA0417164300',
                'bic'    => 'INGBNL2A',
                'owner'  => 'S. McDuck',
            ], new BankAccount()),
            'status'           => (new StatusHydrator())->hydrate([
                'code' => '316',
                'name' => 'Processed',
            ], new Status()),
            'products'         => [
                (new ProductHydrator())->hydrate([
                    'id'          => 'P-0000-0000',
                    'description' => 'Test product',
                    'quantity'    => 1,
                ], new Product()),
                [
                    'id'          => 'P-0000-0001',
                    'description' => 'product as array',
                    'quantity'    => 1,
                ]
            ],
            'reason'           => 'Product was broken',
            'processDate'      => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            '_links' => [
                [
                    'rel' => 'self',
                    'type' => 'GET',
                    'url' => 'https://www.pay.nl/get-refund',
                ]
            ],
        ], new Refund());

        expect($refund->getPaymentSessionId())->string();
        expect($refund->getPaymentSessionId())->equals('100000000');
        expect($refund->getAmount())->isInstanceOf(Amount::class);
        expect($refund->getAmount()->getAmount())->equals(10);
        expect($refund->getAmount()->getCurrency())->equals('EUR');
        expect($refund->getDescription())->string();
        expect($refund->getDescription())->equals('Refund to Scrooge McDuck');
        expect($refund->getBankAccount())->isInstanceOf(BankAccount::class);
        expect($refund->getStatus())->isInstanceOf(Status::class);
        expect($refund->getProducts())->array();
        expect($refund->getProducts())->count(2);
        expect($refund->getProducts())->containsOnlyInstancesOf(Product::class);
        expect($refund->getReason())->string();
        expect($refund->getReason())->equals('Product was broken');
        expect($refund->getProcessDate())->isInstanceOf(DateTime::class);
        expect($refund->getLinks())->isInstanceOf(Links::class);
        expect($refund->getLinks())->count(1);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new RefundHydrator();
        $refund = $hydrator->hydrate([
            'paymentSessionId' => '100000000',
            'amount'           => (new ClassMethods())->hydrate([
                'amount'   => 10,
                'currency' => 'EUR',
            ], new Amount()),
            'description'      => 'Refund to Scrooge McDuck',
            'bankAccount'      => (new BankAccountHydrator())->hydrate([
                'number' => 'NL91ABNA0417164300',
                'bic'    => 'INGBNL2A',
                'owner'  => 'S. McDuck',
            ], new BankAccount()),
            'status'           => (new StatusHydrator())->hydrate([
                'code' => '316',
                'name' => 'Processed',
            ], new Status()),
            'products'         => [
                (new ProductHydrator())->hydrate([
                    'id'          => 'P-0000-0000',
                    'description' => 'Test product',
                    'quantity'    => 1,
                ], new Product()),
                [
                    'id'          => 'P-0000-0001',
                    'description' => 'product as array',
                    'quantity'    => 1,
                ]
            ],
            'reason'           => 'Product was broken',
            'processDate'      => DateTime::createFromFormat('Y-m-d', '2019-09-11'),
            '_links' => [
                [
                    'rel' => 'self',
                    'type' => 'GET',
                    'url' => 'https://www.pay.nl/get-refund',
                ]
            ],
        ], new Refund());

        $data = $hydrator->extract($refund);
        $this->assertIsArray($data);
        verify($data)->hasKey('paymentSessionId');
        verify($data)->hasKey('amount');
        verify($data)->hasKey('description');
        verify($data)->hasKey('bankAccount');
        verify($data)->hasKey('status');
        verify($data)->hasKey('products');
        verify($data)->hasKey('reason');
        verify($data)->hasKey('processDate');
        verify($data)->hasKey('links');

        expect($data['paymentSessionId'])->string();
        expect($data['paymentSessionId'])->equals('100000000');
        expect($data['amount'])->isInstanceOf(Amount::class);
        expect($data['description'])->string();
        expect($data['description'])->equals('Refund to Scrooge McDuck');
        expect($data['bankAccount'])->isInstanceOf(BankAccount::class);
        expect($data['status'])->isInstanceOf(Status::class);
        expect($data['products'])->array();
        expect($data['products'])->count(2);
        expect($data['reason'])->string();
        expect($data['reason'])->equals('Product was broken');
        expect($data['processDate'])->isInstanceOf(DateTime::class);
        expect($data['links'])->isInstanceOf(Links::class);
        expect($data['links'])->count(1);
    }
}

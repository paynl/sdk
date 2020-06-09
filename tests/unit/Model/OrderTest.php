<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\Address;
use PayNL\Sdk\Model\Customer;
use PayNL\Sdk\Model\Order;
use PayNL\Sdk\Model\Product;
use PayNL\Sdk\Model\Products;
use Mockery, DateTime;

/**
 * Class OrderTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class OrderTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Order
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Order();
    }

    /**
     * @return void
     */
    public function testItCanSetOrderId(): void
    {
        $this->tester->assertObjectHasMethod('setOrderId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setOrderId', $this->model);

        $order = $this->model->setOrderId('1234');
    }

    /**
     * @depends testItCanSetOrderId
     *
     * @return void
     */
    public function testItCanGetOrderId(): void
    {
        $this->tester->assertObjectHasMethod('getOrderId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getOrderId', $this->model);

        $orderId = $this->model->getOrderId();
        verify($orderId)->string();
        verify($orderId)->isEmpty();

        $this->model->setOrderId('1234');
        $orderId = $this->model->getOrderId();
        verify($orderId)->string();
        verify($orderId)->notEmpty();
        verify($orderId)->equals('1234');
    }

    /**
     * @return void
     */
    public function testItCanSetOrderNumber(): void
    {
        $this->tester->assertObjectHasMethod('setOrderNumber', $this->model);
        $this->tester->assertObjectMethodIsPublic('setOrderNumber', $this->model);

        $order = $this->model->setOrderNumber('123456789Xabcdef');
        verify($order)->same($this->model);
    }

    /**
     * @depends testItCanSetOrderNumber
     *
     * @return void
     */
    public function testItCanGetOrderNumber(): void
    {
        $this->tester->assertObjectHasMethod('getOrderNumber', $this->model);
        $this->tester->assertObjectMethodIsPublic('getOrderNumber', $this->model);

        $number = $this->model->getOrderNumber();
        verify($number)->string();
        verify($number)->isEmpty();

        $orderNumber = '123456789Xabcdef';
        $this->model->setOrderNumber($orderNumber);

        $number = $this->model->getOrderNumber();
        verify($number)->string();
        verify($number)->notEmpty();
        verify($number)->equals($orderNumber);
    }

    /**
     * @return void
     */
    public function testItCanSetCountyCode(): void
    {
        $this->tester->assertObjectHasMethod('setCountryCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCountryCode', $this->model);

        $order = $this->model->setCountryCode('NL');
        verify($order)->same($this->model);
    }

    /**
     * @depends testItCanSetCountyCode
     *
     * @return void
     */
    public function testItCanGetCountryCode(): void
    {
        $this->tester->assertObjectHasMethod('getCountryCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCountryCode', $this->model);

        $countryCode = $this->model->getCountryCode();
        verify($countryCode)->string();
        verify($countryCode)->isEmpty();

        $this->model->setCountryCode('NL');
        $countryCode = $this->model->getCountryCode();
        verify($countryCode)->string();
        verify($countryCode)->notEmpty();
        verify($countryCode)->equals('NL');
    }

    /**
     * @return void
     */
    public function testItCanSetDeliveryDate(): void
    {
        $this->tester->assertObjectHasMethod('setDeliveryDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDeliveryDate', $this->model);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $order = $this->model->setDeliveryDate($dateTimeMock);
        verify($order)->same($this->model);
    }

    /**
     * @depends testItCanSetDeliveryDate
     *
     * @return void
     */
    public function testItCanGetDeliveryDate(): void
    {
        $this->tester->assertObjectHasMethod('getDeliveryDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDeliveryDate', $this->model);

        $dateTime = $this->model->getDeliveryDate();
        verify($dateTime)->null();

        $dateTimeMock = Mockery::mock(DateTime::class);
        $this->model->setDeliveryDate($dateTimeMock);
        $dateTime = $this->model->getDeliveryDate();
        verify($dateTime)->isInstanceOf(DateTime::class);
    }

    /**
     * @return void
     */
    public function testItCanSetInvoiceDate(): void
    {
        $this->tester->assertObjectHasMethod('setInvoiceDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('setInvoiceDate', $this->model);

        $dateTimeMock = Mockery::mock(DateTime::class);
        $order = $this->model->setInvoiceDate($dateTimeMock);
        verify($order)->same($this->model);
    }

    /**
     * @depends testItCanSetInvoiceDate
     *
     * @return void
     */
    public function testItCanGetInvoiceDate(): void
    {
        $this->tester->assertObjectHasMethod('getInvoiceDate', $this->model);
        $this->tester->assertObjectMethodIsPublic('getInvoiceDate', $this->model);

        $dateTime = $this->model->getInvoiceDate();
        verify($dateTime)->null();

        $dateTimeMock = Mockery::mock(DateTime::class);
        $this->model->setInvoiceDate($dateTimeMock);
        $dateTime = $this->model->getInvoiceDate();
        verify($dateTime)->isInstanceOf(DateTime::class);
    }

    /**
     * @return void
     */
    public function testItCanSetCustomer(): void
    {
        $this->tester->assertObjectHasMethod('setCustomer', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCustomer', $this->model);

        $customerModel = $this->tester->grabMockService('modelManager')->get(Customer::class);
        $order = $this->model->setCustomer($customerModel);
        verify($order)->same($this->model);
    }

    /**
     * @depends testItCanSetCustomer
     *
     * @return void
     */
    public function testItCanGetCustomer(): void
    {
        $this->tester->assertObjectHasMethod('getCustomer', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCustomer', $this->model);

        verify($this->model->getCustomer())->isInstanceOf(Customer::class);

        $customerModel = $this->tester->grabMockService('modelManager')->get(Customer::class);
        $this->model->setCustomer($customerModel);

        $customer = $this->model->getCustomer();
        verify($customer)->object();
        verify($customer)->isInstanceOf(Customer::class);
        verify($customer)->same($customerModel);
    }

    /**
     * @return void
     */
    public function testItCanSetDeliveryAddress(): void
    {
        $this->tester->assertObjectHasMethod('setDeliveryAddress', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDeliveryAddress', $this->model);

        $addressModel = $this->tester->grabMockService('modelManager')->get(Address::class);
        $order = $this->model->setDeliveryAddress($addressModel);
        verify($order)->same($this->model);
    }

    /**
     * @depends testItCanSetDeliveryAddress
     *
     * @return void
     */
    public function testItCanGetDeliveryAddress(): void
    {
        $this->tester->assertObjectHasMethod('getDeliveryAddress', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDeliveryAddress', $this->model);

        verify($this->model->getDeliveryAddress())->isInstanceOf(Address::class);

        $addressModel = $this->tester->grabMockService('modelManager')->get(Address::class);
        $this->model->setDeliveryAddress($addressModel);

        $deliveryAddress = $this->model->getDeliveryAddress();
        verify($deliveryAddress)->object();
        verify($deliveryAddress)->isInstanceOf(Address::class);
        verify($deliveryAddress)->same($addressModel);
    }

    /**
     * @return void
     */
    public function testItCanSetInvoiceAddress(): void
    {
        $this->tester->assertObjectHasMethod('setInvoiceAddress', $this->model);
        $this->tester->assertObjectMethodIsPublic('setInvoiceAddress', $this->model);

        $addressModel = $this->tester->grabMockService('modelManager')->get(Address::class);
        $order = $this->model->setInvoiceAddress($addressModel);
        verify($order)->same($this->model);
    }

    /**
     * @depends testItCanSetInvoiceAddress
     *
     * @return void
     */
    public function testItCanGetInvoiceAddress(): void
    {
        $this->tester->assertObjectHasMethod('getInvoiceAddress', $this->model);
        $this->tester->assertObjectMethodIsPublic('getInvoiceAddress', $this->model);

        verify($this->model->getInvoiceAddress())->isInstanceOf(Address::class);

        $addressModel = $this->tester->grabMockService('modelManager')->get(Address::class);
        $this->model->setInvoiceAddress($addressModel);

        $invoiceAddress = $this->model->getInvoiceAddress();
        verify($invoiceAddress)->object();
        verify($invoiceAddress)->isInstanceOf(Address::class);
        verify($invoiceAddress)->same($addressModel);
    }

    /**
     * @return void
     */
    public function testItCanGetProducts(): void
    {
        $this->tester->assertObjectHasMethod('getProducts', $this->model);
        $this->tester->assertObjectMethodIsPublic('getProducts', $this->model);

        $products = $this->model->getProducts();
        verify($products)->object();
        verify($products)->isInstanceOf(Products::class);
        verify($products)->isEmpty();
    }

    /**
     * @depends testItCanGetProducts
     *
     * @return void
     */
    public function testItCanAddProduct(): void
    {
        $this->tester->assertObjectHasMethod('addProduct', $this->model);
        $this->tester->assertObjectMethodIsPublic('addProduct', $this->model);

        $productMock = $this->tester->grabMockService('modelManager')->get(Product::class);
        $order = $this->model->addProduct($productMock);
        verify($order)->same($this->model);

        $products = $order->getProducts();
        verify($products)->count(1);
        verify($products)->containsOnlyInstancesOf(Product::class);
    }

    /**
     * @depends testItCanGetProducts
     *
     * @return void
     */
    public function testItCanSetProducts(): void
    {
        $this->tester->assertObjectHasMethod('setProducts', $this->model);
        $this->tester->assertObjectMethodIsPublic('setProducts', $this->model);

        $products = $this->model->getProducts();

        $productsMock = $this->tester->grabMockService('modelManager')->get(Products::class);
        $order = $this->model->setProducts($productsMock);
        verify($order)->same($this->model);
        verify($order->getProducts())->notSame($products);
    }
}

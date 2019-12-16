<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\Product as ProductHydrator;
use PayNL\Sdk\Model\{
    Product,
    Amount
};
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;

/**
 * Class ProductTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 *
 */
class ProductTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new ProductHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAProductModel(): void
    {
        $hydrator = new ProductHydrator();
        expect($hydrator->hydrate([], new Product()))->isInstanceOf(Product::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new ProductHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new ProductHydrator();
        $product = $hydrator->hydrate([
            'id'          => 'P-1000-00021',
            'description' => 'Tumbler',
            'quantity'    => 1,
            'vat'         => 'N',
            'price'       => (new ClassMethods())->hydrate([
                'amount'   => '2500000',
                'currency' => 'USD'
            ], new Amount()),
        ], new Product());

        expect($product->getId())->string();
        expect($product->getId())->equals('P-1000-00021');
        expect($product->getDescription())->string();
        expect($product->getDescription())->equals('Tumbler');
        expect($product->getQuantity())->float();
        expect($product->getQuantity())->equals(1);
        expect($product->getVatCode())->string();
        expect($product->getVatCode())->equals('N');
        expect($product->getPrice())->isInstanceOf(Amount::class);
        expect($product->getPrice()->getAmount())->equals(2500000);
        expect($product->getPrice()->getCurrency())->equals('USD');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new ProductHydrator();
        $product = $hydrator->hydrate([
            'id'          => 'P-1000-00021',
            'description' => 'Tumbler',
            'quantity'    => 1,
            'vat'         => 'N',
            'price'       => (new ClassMethods())->hydrate([
                'amount'   => '2500000',
                'currency' => 'USD'
            ], new Amount()),
        ], new Product());

        $data = $hydrator->extract($product);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('description');
        verify($data)->hasKey('quantity');
        verify($data)->hasKey('vat');
        verify($data)->hasKey('price');

        expect($data['id'])->string();
        expect($data['id'])->equals('P-1000-00021');
        expect($data['description'])->string();
        expect($data['description'])->equals('Tumbler');
        expect($data['quantity'])->float();
        expect($data['quantity'])->equals(1);
        expect($data['vat'])->string();
        expect($data['vat'])->equals('N');
        expect($data['price'])->isInstanceOf(Amount::class);
        expect($data['price']->getAmount())->equals(2500000);
        expect($data['price']->getCurrency())->equals('USD');
    }
}

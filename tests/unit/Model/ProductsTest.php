<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Products,
    Product
};
use TypeError;

/**
 * Class ProductsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ProductsTest extends UnitTest
{
    use ModelTestTrait, CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
        testItCanGetCollectionName as traitTestItCanGetCollectionName;
    }

    /**
     * @var Products
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Products();
    }

    /**
     * @param string $id
     *
     * @return Product
     */
    private function getMockProduct(string $id): Product
    {
        /** @var Product $product */
        $product = $this->tester->grabService('modelManager')->build(Product::class);
        $product->setId($id);
        return $product;
    }

    /**
     * @return void
     */
    public function testItCanAddProduct(): void
    {
        $this->tester->assertObjectHasMethod('addProduct', $this->model);
        $this->tester->assertObjectMethodIsPublic('addProduct', $this->model);

        $mockProduct = $this->getMockProduct('foo');

        $products = $this->model->addProduct($mockProduct);
        verify($products)->object();
        verify($products)->same($this->model);
        verify($products)->hasKey($mockProduct->getId());
    }

    /**
     * @depends testItCanAddProduct
     *
     * @return void
     */
    public function testItCanSetProducts(): void
    {
        $this->tester->assertObjectHasMethod('setProducts', $this->model);
        $this->tester->assertObjectMethodIsPublic('setProducts', $this->model);

        $mockProduct = $this->getMockProduct('foo');

        $products = $this->model->setProducts([$mockProduct]);
        verify($products)->object();
        verify($products)->same($this->model);
        verify($products)->containsOnlyInstancesOf(Product::class);
        verify($products)->notEmpty();
        verify($products)->count(1);

        $products = $this->model->setProducts([
            $this->getMockProduct('bar'),
            $this->getMockProduct('baz'),
        ]);
        verify($products)->object();
        verify($products)->same($this->model);
        verify($products)->containsOnlyInstancesOf(Product::class);
        verify($products)->count(2);
        verify($products)->notContains($mockProduct);
    }

    /**
     * @depends testItCanAddProduct
     * @depends testItCanSetProducts
     *
     * @return void
     */
    public function testSetContactMethodsThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);
        $this->model->setProducts([$this->getMockProduct('foo'), []]);
    }

    /**
     * @depends testItCanAddProduct
     * @depends testItCanSetProducts
     *
     * @return void
     */
    public function testItCanSetEmptyContactMethods(): void
    {
        $products = $this->model->setProducts([]);
        verify($products)->isInstanceOf(Products::class);
        verify($products)->same($this->model);
        verify($products)->count(0);
    }

    /**
     * @depends testItCanSetProducts
     *
     * @return void
     */
    public function testItCanGetProducts(): void
    {
        $this->tester->assertObjectHasMethod('getProducts', $this->model);
        $this->tester->assertObjectMethodIsPublic('getProducts', $this->model);

        $mockProduct = $this->getMockProduct('foo');

        $this->model->setProducts([$mockProduct]);
        $products = $this->model->getProducts();
        verify($products)->array();
        verify($products)->count(1);
        verify($products)->hasKey('foo');
        verify($products)->containsOnlyInstancesOf(Product::class);
    }

    /**
     * @depends testItCanSetProducts
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $this->model->setProducts([ $this->getMockProduct('foo') ]);

        // offsetExists
        verify(isset($this->model['foo']))->true();
        verify(isset($this->model['bar']))->false();

        // offsetGet
        verify($this->model['foo'])->isInstanceOf(Product::class);

        // offsetSet
        $this->model['baz'] = $this->getMockProduct('baz');
        verify($this->model)->hasKey('baz');
        verify($this->model)->count(2);

        // offsetUnset
        unset($this->model['foo']);
        verify($this->model)->count(1);
        verify($this->model)->hasntKey('foo');
    }

    /**
     * @inheritDoc
     */
    public function testItCanGetCollectionName(): void
    {
        $this->traitTestItCanGetCollectionName();
        verify($this->model->getCollectionName())->equals('products');
    }
}

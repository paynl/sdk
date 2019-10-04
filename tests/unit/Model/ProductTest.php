<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\Amount;
use PayNL\Sdk\Model\Product;
use PayNL\Sdk\Model\ModelInterface;

/**
 * Class ProductTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ProductTest extends UnitTest
{
    /**
     * @var Product
     */
    protected $product;

    public function _before(): void
    {
        $this->product = new Product();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->product)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->product)->isInstanceOf(\JsonSerializable::class);

        verify($this->product->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->product->setId('P-0000-0001'))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->product->setId('P-0000-0001');

        verify($this->product->getId())->string();
        verify($this->product->getId())->notEmpty();
        verify($this->product->getId())->equals('P-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->product->setDescription('Lightsaber'))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->product->setDescription('Lightsaber');

        verify($this->product->getDescription())->string();
        verify($this->product->getDescription())->notEmpty();
        verify($this->product->getDescription())->equals('Lightsaber');
    }

    /**
     * @return void
     */
    public function testItCanSetAPrice(): void
    {
        expect($this->product->setPrice(new Amount()))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetAPrice
     *
     * @return void
     */
    public function testItCanGetAPrice(): void
    {
        $this->product->setPrice(new Amount());

        verify($this->product->getPrice())->notEmpty();
        verify($this->product->getPrice())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAQuantity(): void
    {
        expect($this->product->setQuantity(10))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetAQuantity
     *
     * @return void
     */
    public function testItCanGetAQuantity(): void
    {
        $this->product->setQuantity(4.5);

        verify($this->product->getQuantity())->float();
        verify($this->product->getQuantity())->notEmpty();
        verify($this->product->getQuantity())->equals(4.5);
    }

    /**
     * @return void
     */
    public function testItCanSetAVat(): void
    {
        expect($this->product->setVat('L'))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetAVat
     *
     * @return void
     */
    public function testItCanGetAVat(): void
    {
        $this->product->setVat('L');

        verify($this->product->getVat())->string();
        verify($this->product->getVat())->notEmpty();
        verify($this->product->getVat())->equals('L');
    }
}

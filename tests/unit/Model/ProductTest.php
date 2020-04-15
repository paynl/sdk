<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Amount,
    Product
};

/**
 * Class ProductTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ProductTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Product
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Product();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        expect($this->model->setId('P-0000-0001'))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $this->model->setId('P-0000-0001');

        verify($this->model->getId())->string();
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->equals('P-0000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('setDescription', $this->model);

        expect($this->model->setDescription('Lightsaber'))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->tester->assertObjectHasMethod('getDescription', $this->model);
        $this->tester->assertObjectMethodIsPublic('getDescription', $this->model);

        $this->model->setDescription('Lightsaber');

        verify($this->model->getDescription())->string();
        verify($this->model->getDescription())->notEmpty();
        verify($this->model->getDescription())->equals('Lightsaber');
    }

    /**
     * @return void
     */
    public function testItCanSetAPrice(): void
    {
        $this->tester->assertObjectHasMethod('setPrice', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPrice', $this->model);

        expect($this->model->setPrice(new Amount()))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetAPrice
     *
     * @return void
     */
    public function testItCanGetAPrice(): void
    {
        $this->tester->assertObjectHasMethod('getPrice', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPrice', $this->model);

        $this->model->setPrice(new Amount());

        verify($this->model->getPrice())->notEmpty();
        verify($this->model->getPrice())->isInstanceOf(Amount::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAQuantity(): void
    {
        $this->tester->assertObjectHasMethod('setQuantity', $this->model);
        $this->tester->assertObjectMethodIsPublic('setQuantity', $this->model);

        expect($this->model->setQuantity(10))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetAQuantity
     *
     * @return void
     */
    public function testItCanGetAQuantity(): void
    {
        $this->tester->assertObjectHasMethod('getQuantity', $this->model);
        $this->tester->assertObjectMethodIsPublic('getQuantity', $this->model);

        $this->model->setQuantity(4.5);

        verify($this->model->getQuantity())->float();
        verify($this->model->getQuantity())->notEmpty();
        verify($this->model->getQuantity())->equals(4.5);
    }

    /**
     * @return void
     */
    public function testItCanSetAVat(): void
    {
        $this->tester->assertObjectHasMethod('setVatCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('setVatCode', $this->model);

        expect($this->model->setVatCode('L'))->isInstanceOf(Product::class);
    }

    /**
     * @depends testItCanSetAVat
     *
     * @return void
     */
    public function testItCanGetAVat(): void
    {
        $this->tester->assertObjectHasMethod('getVatCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('getVatCode', $this->model);

        $this->model->setVatCode('L');

        verify($this->model->getVatCode())->string();
        verify($this->model->getVatCode())->notEmpty();
        verify($this->model->getVatCode())->equals('L');
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Trademark
};
use JsonSerializable;

/**
 * Class CurrencyTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class TrademarkTest extends UnitTest
{
    /**
     * @var Trademark
     */
    protected $trademark;

    public function _before(): void
    {
        $this->trademark = new Trademark();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->trademark)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->trademark)->isInstanceOf(JsonSerializable::class);

        verify($this->trademark->jsonSerialize())->array();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->trademark->setId('T-1000-0001'))->isInstanceOf(Trademark::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->trademark->setId('T-1000-0001');

        verify($this->trademark->getId())->string();
        verify($this->trademark->getId())->notEmpty();
        verify($this->trademark->getId())->equals('T-1000-0001');
    }

    /**
     * @return void
     */
    public function testItCanSetATrademark(): void
    {
        expect($this->trademark->setTrademark('Pay.be'))->isInstanceOf(Trademark::class);
    }

    /**
     * @depends testItCanSetATrademark
     *
     * @return void
     */
    public function testItCanGetATrademark(): void
    {
        $this->trademark->setTrademark('Pay.be');

        verify($this->trademark->getTrademark())->string();
        verify($this->trademark->getTrademark())->notEmpty();
        verify($this->trademark->getTrademark())->equals('Pay.be');
    }
}

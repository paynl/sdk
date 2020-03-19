<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{LinksTrait, ModelInterface, Currency};
use JsonSerializable;

/**
 * Class CurrencyTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CurrencyTest extends UnitTest
{
    /**
     * @var Currency
     */
    protected $currency;

    public function _before(): void
    {
        $this->currency = new Currency();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->currency)->isInstanceOf(ModelInterface::class);
    }

    public function testItUsesLinksTrait(): void
    {
        verify(in_array(LinksTrait::class, class_uses($this->currency), true))->true();
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->currency)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnAbbreviation(): void
    {
        verify(method_exists($this->currency, 'setAbbreviation'))->true();
        verify($this->currency->setAbbreviation('EUR'))->isInstanceOf(Currency::class);
    }

    /**
     * @depends testItCanSetAnAbbreviation
     *
     * @return void
     */
    public function testItCanGetAnAbbreviation(): void
    {
        $this->currency->setAbbreviation('EUR');

        verify(method_exists($this->currency, 'getAbbreviation'))->true();
        verify($this->currency->getAbbreviation())->string();
        verify($this->currency->getAbbreviation())->notEmpty();
        verify($this->currency->getAbbreviation())->equals('EUR');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        verify(method_exists($this->currency, 'setDescription'))->true();
        verify($this->currency->setDescription('Euro'))->isInstanceOf(Currency::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->currency->setDescription('Euro');

        verify(method_exists($this->currency, 'getDescription'))->true();
        verify($this->currency->getDescription())->string();
        verify($this->currency->getDescription())->notEmpty();
        verify($this->currency->getDescription())->equals('Euro');
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{LinksTrait, ModelInterface, Currency};
use JsonSerializable;
use UnitTester;

/**
 * Class CurrencyTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CurrencyTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

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
        $this->tester->assertObjectHasMethod('setAbbreviation', $this->currency);
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

        $this->tester->assertObjectHasMethod('getAbbreviation', $this->currency);
        verify($this->currency->getAbbreviation())->string();
        verify($this->currency->getAbbreviation())->notEmpty();
        verify($this->currency->getAbbreviation())->equals('EUR');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        $this->tester->assertObjectHasMethod('setDescription', $this->currency);
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

        $this->tester->assertObjectHasMethod('getDescription', $this->currency);
        verify($this->currency->getDescription())->string();
        verify($this->currency->getDescription())->notEmpty();
        verify($this->currency->getDescription())->equals('Euro');
    }
}

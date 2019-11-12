<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Links,
    Currency
};
use JsonSerializable;
use PayNL\Sdk\Hydrator\Links as LinksHydrator;

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
    public function testItCanSetLinks(): void
    {
        verify(method_exists($this->currency, 'setLinks'))->true();
        verify($this->currency->setLinks(new Links()))->isInstanceOf(Currency::class);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->currency, 'getLinks'))->true();

        $this->currency->setLinks(
            (new LinksHydrator())->hydrate([
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'http://some.url.com',
                ],
            ], new Links())
        );

        verify($this->currency->getLinks())->isInstanceOf(Links::class);
        verify($this->currency->getLinks())->count(1);
        verify($this->currency->getLinks())->hasKey('self');
    }

    /**
     * @return void
     */
    public function testItCanSetAnAbbreviation(): void
    {
        expect($this->currency->setAbbreviation('EUR'))->isInstanceOf(Currency::class);
    }

    /**
     * @depends testItCanSetAnAbbreviation
     *
     * @return void
     */
    public function testItCanGetAnAbbreviation(): void
    {
        $this->currency->setAbbreviation('EUR');

        verify($this->currency->getAbbreviation())->string();
        verify($this->currency->getAbbreviation())->notEmpty();
        verify($this->currency->getAbbreviation())->equals('EUR');
    }

    /**
     * @return void
     */
    public function testItCanSetADescription(): void
    {
        expect($this->currency->setDescription('Euro'))->isInstanceOf(Currency::class);
    }

    /**
     * @depends testItCanSetADescription
     *
     * @return void
     */
    public function testItCanGetADescription(): void
    {
        $this->currency->setDescription('Euro');

        verify($this->currency->getDescription())->string();
        verify($this->currency->getDescription())->notEmpty();
        verify($this->currency->getDescription())->equals('Euro');
    }
}

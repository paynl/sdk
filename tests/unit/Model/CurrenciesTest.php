<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Links,
    Currency,
    Currencies
};
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Hydrator\{
    Simple as SimpleHydrator,
    Links as LinksHydrator
};
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate, Exception;

/**
 * Class CurrenciesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CurrenciesTest extends UnitTest
{
    /**
     * @var Currencies
     */
    protected $currencies;

    public function _before(): void
    {
        $this->currencies = new Currencies();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->currencies)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->currencies)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        verify(method_exists($this->currencies, 'setLinks'))->true();
        verify($this->currencies->setLinks(new Links()))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->currencies, 'getLinks'))->true();

        $this->currencies->setLinks(
            (new LinksHydrator())->hydrate([
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'http://some.url.com',
                ],
            ], new Links())
        );

        verify($this->currencies->getLinks())->isInstanceOf(Links::class);
        verify($this->currencies->getLinks())->count(1);
        verify($this->currencies->getLinks())->hasKey('self');
    }

    /**
     * @return void
     */
    public function testItCanAddCurrency(): void
    {
        verify(method_exists($this->currencies, 'addCurrency'))->true();
        verify($this->currencies->addCurrency((new SimpleHydrator())->hydrate([
            'abbreviation' => 'EUR',
            'description'  => 'Euro',
        ], new Currency())))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanAddCurrency
     *
     * @return void
     */
    public function testItCanSetCurrencies(): void
    {
        verify(method_exists($this->currencies, 'setCurrencies'))->true();
        verify($this->currencies->setCurrencies([]))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanSetCurrencies
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetCurrencies(): void
    {
        verify(method_exists($this->currencies, 'getCurrencies'))->true();

        $this->currencies->setCurrencies([
            (new SimpleHydrator())->hydrate([
                'abbreviation' => 'EUR',
                'description'  => 'Euro',
            ], new Currency()),
            (new SimpleHydrator())->hydrate([
                'abbreviation' => 'USD',
                'description'  => 'US Dollar',
            ], new Currency()),
        ])->setTotal(2);

        verify($this->currencies->getCurrencies())->array();
        verify($this->currencies->getCurrencies())->count(2);
    }

    /**
     * @return void
     */
    public function testItCanSetTotal(): void
    {
        verify(method_exists($this->currencies, 'setTotal'))->true();
        verify($this->currencies->setTotal(1))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanSetTotal
     *
     * @return void
     */
    public function testItCanGetTotal(): void
    {
        verify(method_exists($this->currencies, 'getTotal'))->true();

        $this->currencies->setTotal(1);

        verify($this->currencies->getTotal())->int();
        verify($this->currencies->getTotal())->notEmpty();
        verify($this->currencies->getTotal())->equals(1);
    }


    /**
     * @depends testItCanSetCurrencies
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->currencies)->isInstanceOf(Countable::class);

        $this->currencies->setCurrencies([
            (new SimpleHydrator())->hydrate([
                'abbreviation' => 'EUR',
                'description'  => 'Euro',
            ], new Currency()),
            (new SimpleHydrator())->hydrate([
                'abbreviation' => 'USD',
                'description'  => 'US Dollar',
            ], new Currency()),
        ])->setTotal(2);

        verify(count($this->currencies))->equals(2);
    }

    /**
     * @depends testItCanSetCurrencies
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->currencies)->isInstanceOf(ArrayAccess::class);

        $this->currencies->setCurrencies([
            (new SimpleHydrator())->hydrate([
                'abbreviation' => 'EUR',
                'description'  => 'Euro',
            ], new Currency()),
            (new SimpleHydrator())->hydrate([
                'abbreviation' => 'USD',
                'description'  => 'US Dollar',
            ], new Currency()),
        ])->setTotal(2);

        // offsetExists
        verify(isset($this->currencies['EUR']))->true();
        verify(isset($this->currencies['non_existing_key']))->false();

        // offsetGet
        verify($this->currencies['EUR'])->isInstanceOf(Currency::class);

        // offsetSet
        $this->currencies['EUR'] = (new SimpleHydrator())->hydrate([
            'abbreviation' => 'AUD',
            'description'  => 'Australian Dollar',
        ], new Currency());
        verify($this->currencies)->hasKey('AUD');
        verify($this->currencies)->count(3);

        // offsetUnset
        unset($this->currencies['USD']);
        verify($this->currencies)->count(2);
        verify($this->currencies)->hasntKey('USD');
    }

    /**
     * @depends testItCanSetCurrencies
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->currencies)->isInstanceOf(IteratorAggregate::class);

        $this->currencies->setCurrencies([
            (new SimpleHydrator())->hydrate([
                'abbreviation' => 'EUR',
                'description'  => 'Euro',
            ], new Currency()),
            (new SimpleHydrator())->hydrate([
                'abbreviation' => 'USD',
                'description'  => 'US Dollar',
            ], new Currency()),
        ])->setTotal(2);

        verify(is_iterable($this->currencies))->true();
    }
}

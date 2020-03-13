<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{LinksTrait, ModelInterface, Links, Currency, Currencies};
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate, Exception;
use PayNL\Sdk\Common\AbstractTotalCollection;

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

    private function eurCurrency(): Currency
    {
        return (new Currency())
            ->setAbbreviation('EUR')
            ->setDescription('Euro');
    }

    private function usdCurrency(): Currency
    {
        return (new Currency())
            ->setAbbreviation('USD')
            ->setDescription('Dollar');
    }

    private function audCurrency(): Currency
    {
        return (new Currency())
            ->setAbbreviation('AUD')
            ->setDescription('Australian Dollar');
    }

    /**
     * @return void
     */
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
    public function testItIsATotalCollection(): void
    {
        verify($this->currencies)->isInstanceOf(AbstractTotalCollection::class);
    }

    /**
     * @return void
     */
    public function testItIsNotJsonSerializable(): void
    {
        verify($this->currencies)->isNotInstanceOf(JsonSerializable::class);
    }

    public function testItUsesLinksTrait(): void
    {
        verify(in_array(LinksTrait::class, class_uses($this->currencies), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanAddCurrency(): void
    {
        verify(method_exists($this->currencies, 'addCurrency'))->true();
        verify($this->currencies->addCurrency($this->eurCurrency()))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanAddCurrency
     *
     * @return void
     */
    public function testItCanSetEmptyCurrencies(): void
    {
        verify(method_exists($this->currencies, 'setCurrencies'))->true();
        verify($this->currencies->setCurrencies([$this->eurCurrency()]))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanSetEmptyCurrencies
     */
    public function testItCanSetSomeCurrencies(): void
    {
        verify($this->currencies->setCurrencies([$this->eurCurrency()]))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanSetSomeCurrencies
     * @depends testItCanSetEmptyCurrencies
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanGetCurrencies(): void
    {
        verify(method_exists($this->currencies, 'getCurrencies'))->true();

        $this->currencies->setCurrencies([
            $this->eurCurrency(),
            $this->usdCurrency()
        ])->setTotal(2);

        verify($this->currencies->getCurrencies())->array();
        verify($this->currencies->getCurrencies())->count(2);
    }

    /**
     * @depends testItCanSetSomeCurrencies
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->currencies)->isInstanceOf(Countable::class);

        $this->currencies->setCurrencies([
            $this->eurCurrency(),
            $this->usdCurrency()
        ])->setTotal(2);

        verify(count($this->currencies))->equals(2);
    }

    /**
     * @depends testItCanSetSomeCurrencies
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->currencies)->isInstanceOf(ArrayAccess::class);

        $this->currencies
            ->setCurrencies([
                $this->eurCurrency(),
                $this->usdCurrency()
            ])
            ->setTotal(2);

        // offsetExists
        verify(isset($this->currencies['EUR']))->true();
        verify(isset($this->currencies['non_existing_key']))->false();

        // offsetGet
        verify($this->currencies['EUR'])->isInstanceOf(Currency::class);

        // offsetSet
        $audCurrency = (new Currency())
            ->setAbbreviation('AUD')
            ->setDescription('Australian Dollar');

        $this->currencies['AUD'] = $audCurrency;
        verify($this->currencies)->hasKey('AUD');
        verify($this->currencies)->count(3);

        // offsetUnset
        unset($this->currencies['USD']);
        verify($this->currencies)->count(2);
        verify($this->currencies)->hasntKey('USD');
    }

    /**
     * @depends testItCanSetSomeCurrencies
     *
     * @throws Exception
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->currencies)->isInstanceOf(IteratorAggregate::class);

        $this->currencies->setCurrencies([
            (new Currency())
                ->setDescription('EUR')
                ->setDescription('Euro'),
            (new Currency())
                ->setDescription('USD')
                ->setDescription('US Dollar')
        ])->setTotal(2);

        verify(is_iterable($this->currencies))->true();
    }
}

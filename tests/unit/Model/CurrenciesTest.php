<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Lib\CollectionTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Member\LinksAwareTrait,
    Currency,
    Currencies
};

/**
 * Class CurrenciesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class CurrenciesTest extends UnitTest
{
    use ModelTestTrait;
    use CollectionTestTrait {
        testItCanBeAccessedLikeAnArray as traitTestItCanBeAccessedLikeAnArray;
    }

    /**
     * @var Currencies
     */
    protected $model;

    /**
     * @return Currency
     */
    private function eurCurrency(): Currency
    {
        return ($this->tester->grabService('modelManager')->build('Currency'))
            ->setAbbreviation('EUR')
            ->setDescription('Euro');
    }

    /**
     * @return Currency
     */
    private function usdCurrency(): Currency
    {
        return ($this->tester->grabService('modelManager')->build('Currency'))
            ->setAbbreviation('USD')
            ->setDescription('Dollar');
    }

    /**
     * @return Currency
     */
    private function audCurrency(): Currency
    {
        return ($this->tester->grabService('modelManager')->build('Currency'))
            ->setAbbreviation('AUD')
            ->setDescription('Australian Dollar');
    }

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsTotalCollection();
        $this->model = new Currencies();
    }

    /**
     * @return void
     */
    public function testItUsesLinksTrait(): void
    {
        $this->tester->assertObjectUsesTrait($this->model, LinksAwareTrait::class);
    }

    /**
     * @return void
     */
    public function testItCanAddCurrency(): void
    {
        $this->tester->assertObjectHasMethod('addCurrency', $this->model);
        $this->tester->assertObjectMethodIsPublic('addCurrency', $this->model);

        verify($this->model->addCurrency($this->eurCurrency()))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanAddCurrency
     *
     * @return void
     */
    public function testItCanSetEmptyCurrencies(): void
    {
        $this->tester->assertObjectHasMethod('setCurrencies', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCurrencies', $this->model);

        verify($this->model->setCurrencies([]))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanSetEmptyCurrencies
     */
    public function testItCanSetSomeCurrencies(): void
    {
        verify($this->model->setCurrencies([$this->eurCurrency()]))->isInstanceOf(Currencies::class);
    }

    /**
     * @depends testItCanSetSomeCurrencies
     * @depends testItCanSetEmptyCurrencies
     *
     * @return void
     */
    public function testItCanGetCurrencies(): void
    {
        $this->tester->assertObjectHasMethod('getCurrencies', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCurrencies', $this->model);

        $this->model->setCurrencies([
            $this->eurCurrency(),
            $this->usdCurrency()
        ])->setTotal(2);

        verify($this->model->getCurrencies())->array();
        verify($this->model->getCurrencies())->count(2);
    }

    /**
     * @depends testItCanSetSomeCurrencies
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        $this->traitTestItCanBeAccessedLikeAnArray();

        $this->model
            ->setCurrencies([
                $this->eurCurrency(),
                $this->usdCurrency()
            ])
            ->setTotal(2);

        // offsetExists
        verify(isset($this->model['EUR']))->true();
        verify(isset($this->model['non_existing_key']))->false();

        // offsetGet
        verify($this->model['EUR'])->isInstanceOf(Currency::class);

        // offsetSet
        $this->model['AUD'] = $this->audCurrency();
        verify($this->model)->hasKey('AUD');
        verify($this->model)->count(3);

        // offsetUnset
        unset($this->model['USD']);
        verify($this->model)->count(2);
        verify($this->model)->hasntKey('USD');
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Hydrator\Currencies as CurrenciesHydrator,
    Model\Currencies,
    Model\Currency
};
use Zend\Hydrator\HydratorInterface;
use Exception;

/**
 * Class CurrenciesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class CurrenciesTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new CurrenciesHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptACurrenciesModel(): void
    {
        $hydrator = new CurrenciesHydrator();
        expect($hydrator->hydrate(['currencies' => []], new Currencies()))->isInstanceOf(Currencies::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new CurrenciesHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new CurrenciesHydrator();
        $currencies = $hydrator->hydrate([
            'currencies' => [
                [
                    'abbreviation' => 'EUR',
                    'description'  => 'Euro'
                ],
                [
                    'abbreviation' => 'USD',
                    'description'  => 'US Dollar'
                ],
            ],
        ], new Currencies());

        expect($currencies->getCurrencies())->array();
        expect($currencies->getCurrencies())->count(2);
        expect($currencies->getCurrencies())->containsOnlyInstancesOf(Currency::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new CurrenciesHydrator();
        $currencies = $hydrator->hydrate([
            'currencies' => [
                [
                    'abbreviation' => 'EUR',
                    'description'  => 'Euro'
                ],
                [
                    'abbreviation' => 'USD',
                    'description'  => 'US Dollar'
                ],
            ],
        ], new Currencies());

        $data = $hydrator->extract($currencies);
        $this->assertIsArray($data);
        verify($data)->hasKey('currencies');

        expect($data['currencies'])->array();
        expect($data['currencies'])->count(2);
        expect($data['currencies'])->containsOnlyInstancesOf(Currency::class);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    TransformerInterface,
    Currencies as CurrenciesTransformer
};
use PayNL\Sdk\Model\{
    Currencies,
    Currency
};

/**
 * Class CurrenciesTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class CurrenciesTest extends UnitTest
{
    /**
     * @var CurrenciesTransformer
     */
    protected $currenciesTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->currenciesTransformer = new CurrenciesTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->currenciesTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->currenciesTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransform(): void
    {
        $input = json_encode([
            'currencies' => [
                [
                    'abbreviation' => 'EUR',
                    'description'  => 'Euro',
                ],
                [
                    'abbreviation' => 'USD',
                    'description'  => 'US Dollar',
                ],
            ],
        ]);

        $output = $this->currenciesTransformer->transform($input);
        verify($output)->isInstanceOf(Currencies::class);
        verify($output)->count(2);
        verify($output)->containsOnlyInstancesOf(Currency::class);
    }
}

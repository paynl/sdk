<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Currency as CurrencyTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\Currency;

/**
 * Class CurrencyTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class CurrencyTest extends UnitTest
{
    /**
     * @var CurrencyTransformer
     */
    protected $currencyTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->currencyTransformer = new CurrencyTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->currencyTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->currencyTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformMultiple(): void
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

        $output = $this->currencyTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('currencies');
        verify($output['currencies'])->array();
        verify($output['currencies'])->containsOnlyInstancesOf(Currency::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformSingle(): void
    {
        $input = json_encode([
            'abbreviation' => 'EUR',
            'description'  => 'Euro',
        ]);

        $output = $this->currencyTransformer->transform($input);
        verify($output)->isInstanceOf(Currency::class);
    }
}

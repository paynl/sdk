<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    Merchant as MerchantTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\Merchant;

/**
 * Class MerchantTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class MerchantTest extends UnitTest
{
    /**
     * @var MerchantTransformer
     */
    protected $merchantTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->merchantTransformer = new MerchantTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->merchantTransformer)->isInstanceOf(TransformerInterface::class);
    }

    public function testItExtendsAbstract(): void
    {
        verify($this->merchantTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    public function testItCanTransformMultiple(): void
    {
        $input = json_encode([
            'merchants' => [
               [],
            ],
        ]);

        $output = $this->merchantTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('merchants');
        verify($output['merchants'])->array();
        verify($output['merchants'])->count(2);
        verify($output['merchants'])->containsOnlyInstancesOf(Merchant::class);
    }

    // TODO fix the merchant transformer test

//    public function testItCanTransformSingle(): void
//    {
//        $input = json_encode([
//            'abbreviation' => 'EUR',
//            'description'  => 'Euro',
//        ]);
//
//        $output = $this->merchantTransformer->transform($input);
//        verify($output)->isInstanceOf(Currency::class);
//    }
}

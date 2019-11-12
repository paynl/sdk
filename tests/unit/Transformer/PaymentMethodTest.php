<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    PaymentMethod as PaymentMethodTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\PaymentMethod;

/**
 * Class PaymentMethodTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class PaymentMethodTest extends UnitTest
{
    /**
     * @var PaymentMethodTransformer
     */
    protected $paymentMethodTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->paymentMethodTransformer = new PaymentMethodTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->paymentMethodTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->paymentMethodTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformMultiple(): void
    {
        $input = json_encode([
            'paymentMethods' => [
                [
                    'id'       => '10',
                    'name'     => 'iDeal',
                    'settings' => [
                        'returnUrl=https://www.pay.nl/complete',
                    ],
                ],
                [
                    'id'       => '138',
                    'name'     => 'PayPal',
                ],
            ],
        ]);

        $output = $this->paymentMethodTransformer->transform($input);
        verify($output)->array();
        verify($output)->hasKey('paymentMethods');
        verify($output)->count(1);
        verify($output['paymentMethods'])->array();
        verify($output['paymentMethods'])->containsOnlyInstancesOf(PaymentMethod::class);
        verify($output['paymentMethods'])->count(2);
    }
}

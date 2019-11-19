<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Transformer;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Transformer\{
    AbstractTransformer,
    PaymentMethods as PaymentMethodsTransformer,
    TransformerInterface
};
use PayNL\Sdk\Model\{
    PaymentMethods,
    PaymentMethod
};

/**
 * Class PaymentMethodTest
 *
 * @package Tests\Unit\PayNL\Sdk\Transformer
 */
class PaymentMethodsTest extends UnitTest
{
    /**
     * @var PaymentMethodsTransformer
     */
    protected $paymentMethodsTransformer;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->paymentMethodsTransformer = new PaymentMethodsTransformer();
    }

    /**
     * @return void
     */
    public function testItImplementsInterface(): void
    {
        verify($this->paymentMethodsTransformer)->isInstanceOf(TransformerInterface::class);
    }

    /**
     * @return void
     */
    public function testItExtendsAbstract(): void
    {
        verify($this->paymentMethodsTransformer)->isInstanceOf(AbstractTransformer::class);
    }

    /**
     * @return void
     */
    public function testItCanTransformMultiple(): void
    {
        $input = json_encode([
            'paymentMethods' => [
                [
                    'id'           => '10',
                    'subId'        => 1,
                    'name'         => 'iDeal',
                    'image'        => 'https://admin.pay.nl/images/payment_profiles/10.gif',
                    'countryCodes' => [
                        'NL'
                    ],
                    'subMethods' => [
                        [
                            'id'    => 1,
                            'name'  => 'ABN Amro',
                            'image' => 'https://admin.pay.nl/images/payment_banks/1.png'
                        ],
                        [
                            'id'    => 8,
                            'name'  => 'ASN Bank',
                            'image' => 'https://admin.pay.nl/images/payment_banks/8.png'
                        ]
                    ]
                ],
                [
                    'id'       => '138',
                    'name'     => 'PayPal',
                ],
            ],
        ]);

        $output = $this->paymentMethodsTransformer->transform($input);
        verify($output)->isInstanceOf(PaymentMethods::class);
        verify($output)->count(2);
        verify($output)->containsOnlyInstancesOf(PaymentMethod::class);
    }
}

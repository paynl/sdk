<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Hydrator\PaymentMethods as PaymentMethodsHydrator,
    Model\PaymentMethods,
    Model\PaymentMethod
};
use Zend\Hydrator\HydratorInterface;
use Exception;

/**
 * Class PaymentMethodsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class PaymentMethodsTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new PaymentMethodsHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAPaymentMethodsModel(): void
    {
        $hydrator = new PaymentMethodsHydrator();
        expect($hydrator->hydrate(['paymentMethods' => []], new PaymentMethods()))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new PaymentMethodsHydrator();

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
        $hydrator = new PaymentMethodsHydrator();
        $paymentMethods = $hydrator->hydrate([
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
                ]
            ],
        ], new PaymentMethods());

        expect($paymentMethods->getPaymentMethods())->array();
        expect($paymentMethods->getPaymentMethods())->count(2);
        expect($paymentMethods->getPaymentMethods())->containsOnlyInstancesOf(PaymentMethod::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new PaymentMethodsHydrator();
        $paymentMethods = $hydrator->hydrate([
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
                ]
            ],
        ], new PaymentMethods());

        $data = $hydrator->extract($paymentMethods);
        $this->assertIsArray($data);
        verify($data)->hasKey('paymentMethods');

        expect($data['paymentMethods'])->array();
        expect($data['paymentMethods'])->count(2);
        expect($data['paymentMethods'])->containsOnlyInstancesOf(PaymentMethod::class);
    }
}

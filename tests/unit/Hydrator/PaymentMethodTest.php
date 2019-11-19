<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Hydrator\PaymentMethod as PaymentMethodHydrator,
    Model\PaymentMethod,
    Model\PaymentMethods
};
use Zend\Hydrator\HydratorInterface;

/**
 * Class PaymentMethodTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 *
 */
class PaymentMethodTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new PaymentMethodHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAPaymentMethodModel(): void
    {
        $hydrator = new PaymentMethodHydrator();
        expect($hydrator->hydrate([], new PaymentMethod()))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new PaymentMethodHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new PaymentMethodHydrator();
        $paymentMethod = $hydrator->hydrate([
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
        ], new PaymentMethod());

        expect($paymentMethod->getId())->int();
        expect($paymentMethod->getId())->equals(10);
        expect($paymentMethod->getSubId())->int();
        expect($paymentMethod->getSubId())->equals(1);
        expect($paymentMethod->getName())->string();
        expect($paymentMethod->getName())->equals('iDeal');
        expect($paymentMethod->getImage())->string();
        expect($paymentMethod->getImage())->equals('https://admin.pay.nl/images/payment_profiles/10.gif');
        expect($paymentMethod->getCountryCodes())->array();
        expect($paymentMethod->getCountryCodes())->count(1);
        expect($paymentMethod->getCountryCodes())->contains('NL');
        expect($paymentMethod->getSubMethods())->isInstanceOf(PaymentMethods::class);
        expect($paymentMethod->getSubMethods())->count(2);
        expect($paymentMethod->getSubMethods())->hasKey(1);
        expect($paymentMethod->getSubMethods())->hasKey(8);
        expect($paymentMethod->getSubMethods())->containsOnlyInstancesOf(PaymentMethod::class);

        $paymentMethod = $hydrator->hydrate([
            'id'           => 138,
            'subId'        => null,
            'name'         => 'PayPal',
            'subMethods'   => null,
        ], new PaymentMethod());

        expect($paymentMethod->getId())->int();
        expect($paymentMethod->getId())->equals(138);
        expect($paymentMethod->getSubId())->null();
        expect($paymentMethod->getName())->string();
        expect($paymentMethod->getName())->equals('PayPal');
        expect($paymentMethod->getImage())->string();
        expect($paymentMethod->getImage())->isEmpty();
        expect($paymentMethod->getCountryCodes())->array();
        expect($paymentMethod->getCountryCodes())->isEmpty();
        expect($paymentMethod->getSubMethods())->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new PaymentMethodHydrator();
        $paymentMethod = $hydrator->hydrate([
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
        ], new PaymentMethod());

        $data = $hydrator->extract($paymentMethod);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('subId');
        verify($data)->hasKey('name');
        verify($data)->hasKey('image');
        verify($data)->hasKey('countryCodes');
        verify($data)->hasKey('subMethods');

        expect($data['id'])->int();
        expect($data['id'])->equals(10);
        expect($data['subId'])->int();
        expect($data['subId'])->equals(1);
        expect($data['name'])->string();
        expect($data['name'])->equals('iDeal');
        expect($data['image'])->string();
        expect($data['image'])->equals('https://admin.pay.nl/images/payment_profiles/10.gif');
        expect($data['countryCodes'])->array();
        expect($data['countryCodes'])->count(1);
        expect($data['countryCodes'])->contains('NL');
        expect($data['subMethods'])->isInstanceOf(PaymentMethods::class);
        expect($data['subMethods'])->count(2);
        expect($data['subMethods'])->hasKey(1);
        expect($data['subMethods'])->hasKey(8);
        expect($data['subMethods'])->containsOnlyInstancesOf(PaymentMethod::class);
    }
}

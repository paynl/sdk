<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Links,
    PaymentMethod,
    PaymentMethods
};
use PayNL\Sdk\Hydrator\{
    PaymentMethod as PaymentMethodHydrator,
    Links as LinksHydrator
};
use JsonSerializable, Countable, ArrayAccess, IteratorAggregate;

/**
 * Class PaymentMethodsTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class PaymentMethodsTest extends UnitTest
{
    /**
     * @var PaymentMethods
     */
    protected $paymentMethods;

    public function _before(): void
    {
        $this->paymentMethods = new PaymentMethods();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->paymentMethods)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->paymentMethods)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetLinks(): void
    {
        verify(method_exists($this->paymentMethods, 'setLinks'))->true();
        verify($this->paymentMethods->setLinks(new Links()))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanSetLinks
     *
     * @return void
     */
    public function testItCanGetLinks(): void
    {
        verify(method_exists($this->paymentMethods, 'getLinks'))->true();

        $this->paymentMethods->setLinks(
            (new LinksHydrator())->hydrate([
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'http://some.url.com',
                ],
            ], new Links())
        );

        verify($this->paymentMethods->getLinks())->isInstanceOf(Links::class);
        verify($this->paymentMethods->getLinks())->count(1);
        verify($this->paymentMethods->getLinks())->hasKey('self');
    }

    /**
     * @return void
     */
    public function testItCanAddPaymentMethod(): void
    {
        verify(method_exists($this->paymentMethods, 'addPaymentMethod'))->true();
        verify($this->paymentMethods->addPaymentMethod((new PaymentMethodHydrator())->hydrate([
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
        ], new PaymentMethod())))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanAddPaymentMethod
     *
     * @return void
     */
    public function testItCanSetPaymentMethods(): void
    {
        verify(method_exists($this->paymentMethods, 'setPaymentMethods'))->true();
        verify($this->paymentMethods->setPaymentMethods([]))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItCanGetPaymentMethods(): void
    {
        verify(method_exists($this->paymentMethods, 'getPaymentMethods'))->true();

        $this->paymentMethods->setPaymentMethods([
            (new PaymentMethodHydrator())->hydrate([
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
            ], new PaymentMethod()),
        ]);

        verify($this->paymentMethods->getPaymentMethods())->array();
        verify($this->paymentMethods->getPaymentMethods())->count(1);
    }

    /**
     * @return void
     */
    public function testItCanSetTotal(): void
    {
        verify(method_exists($this->paymentMethods, 'setTotal'))->true();
        verify($this->paymentMethods->setTotal(1))->isInstanceOf(PaymentMethods::class);
    }

    /**
     * @depends testItCanSetTotal
     *
     * @return void
     */
    public function testItCanGetTotal(): void
    {
        verify(method_exists($this->paymentMethods, 'getTotal'))->true();

        $this->paymentMethods->setTotal(1);

        verify($this->paymentMethods->getTotal())->int();
        verify($this->paymentMethods->getTotal())->notEmpty();
        verify($this->paymentMethods->getTotal())->equals(1);
    }


    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItIsCountable(): void
    {
        verify($this->paymentMethods)->isInstanceOf(Countable::class);

        $this->paymentMethods->setPaymentMethods([
            (new PaymentMethodHydrator())->hydrate([
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
            ], new PaymentMethod()),
        ])->setTotal(1);

        verify(count($this->paymentMethods))->equals(1);
    }

    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItCanBeAccessedLikeAnArray(): void
    {
        verify($this->paymentMethods)->isInstanceOf(ArrayAccess::class);

        $this->paymentMethods->setPaymentMethods([
            (new PaymentMethodHydrator())->hydrate([
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
            ], new PaymentMethod()),
        ])->setTotal(1);

        // offsetExists
        verify(isset($this->paymentMethods[10]))->true();
        verify(isset($this->paymentMethods['non_existing_key']))->false();

        // offsetGet
        verify($this->paymentMethods[10])->isInstanceOf(PaymentMethod::class);

        // offsetSet
        $this->paymentMethods[138] = (new PaymentMethodHydrator())->hydrate([
            'id'       => '138',
            'name'     => 'PayPal',
        ], new PaymentMethod());
        verify($this->paymentMethods)->hasKey(138);
        verify($this->paymentMethods)->count(2);

        // offsetUnset
        unset($this->paymentMethods[10]);
        verify($this->paymentMethods)->count(1);
        verify($this->paymentMethods)->hasntKey(10);
    }

    /**
     * @depends testItCanSetPaymentMethods
     *
     * @return void
     */
    public function testItCanBeIterated(): void
    {
        verify($this->paymentMethods)->isInstanceOf(IteratorAggregate::class);

        $this->paymentMethods->setPaymentMethods([
            (new PaymentMethodHydrator())->hydrate([
                'id'       => '138',
                'name'     => 'PayPal',
            ], new PaymentMethod()),
        ])->setTotal(1);

        verify(is_iterable($this->paymentMethods))->true();
    }
}

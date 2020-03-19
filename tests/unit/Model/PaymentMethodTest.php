<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    PaymentMethod,
    PaymentMethods
};
use PayNL\Sdk\Common\JsonSerializeTrait;
use PayNL\Sdk\Exception\InvalidArgumentException;
use JsonSerializable;
use UnitTester;

/**
 * Class PaymentMethodTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class PaymentMethodTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @var PaymentMethod
     */
    protected $paymentMethod;

    public function _before(): void
    {
        $this->paymentMethod = new PaymentMethod();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->paymentMethod)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->paymentMethod)->isInstanceOf(JsonSerializable::class);
    }

    public function testItHasJsonSerializeTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->paymentMethod), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        expect($this->paymentMethod->setId(10))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->paymentMethod->setId(10);

        verify($this->paymentMethod->getId())->int();
        verify($this->paymentMethod->getId())->notEmpty();
        verify($this->paymentMethod->getId())->equals(10);
    }

    /**
     * @return void
     */
    public function testItCanSetASubId(): void
    {
        verify($this->paymentMethod->setSubId(8))->isInstanceOf(PaymentMethod::class);
        verify($this->paymentMethod->setSubId('8'))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetASubId
     *
     * @return void
     */
    public function testItCanGetASubId(): void
    {
        verify($this->paymentMethod->getSubId())->isEmpty();

        $this->paymentMethod->setSubId(8);

        verify($this->paymentMethod->getSubId())->string();
        verify($this->paymentMethod->getSubId())->notEmpty();
        verify($this->paymentMethod->getSubId())->equals('8');
    }

    /**
     * @depends testItCanSetASubId
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenSubIdIsNotAStringNorAnInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->paymentMethod->setSubId(array());
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        expect($this->paymentMethod->setName('iDeal'))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->paymentMethod->setName('iDeal');

        verify($this->paymentMethod->getName())->string();
        verify($this->paymentMethod->getName())->notEmpty();
        verify($this->paymentMethod->getName())->equals('iDeal');
    }

    /**
     * @return void
     */
    public function testItCanSetAnImage(): void
    {
        expect($this->paymentMethod->setImage('http://www.pay.nl/link-to-image'))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetAnImage
     *
     * @return void
     */
    public function testItCanGetAnImage(): void
    {
        $this->paymentMethod->setImage('http://www.pay.nl/link-to-image');

        verify($this->paymentMethod->getImage())->string();
        verify($this->paymentMethod->getImage())->notEmpty();
        verify($this->paymentMethod->getImage())->equals('http://www.pay.nl/link-to-image');
    }

    /**
     * @return void
     */
    public function testItCanSetCountryCodes(): void
    {
        expect($this->paymentMethod->setCountryCodes([]))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetCountryCodes
     *
     * @return void
     */
    public function testItCanGetCountryCodes(): void
    {
        $this->paymentMethod->setCountryCodes([ 'NL', 'BE' ]);

        verify($this->paymentMethod->getCountryCodes())->array();
        verify($this->paymentMethod->getCountryCodes())->notEmpty();
        verify($this->paymentMethod->getCountryCodes())->count(2);
        verify($this->paymentMethod->getCountryCodes())->contains('NL');
        verify($this->paymentMethod->getCountryCodes())->contains('BE');
        verify($this->paymentMethod->getCountryCodes())->containsOnly('string');
    }

    /**
     * @depends testItCanSetCountryCodes
     * @depends testItCanGetCountryCodes
     *
     * @return void
     */
    public function testItCanAddCountryCode(): void
    {
        $this->paymentMethod->setCountryCodes([ 'NL', 'BE', 'DE' ]);

        $this->paymentMethod->addCountryCode('FR');

        verify($this->paymentMethod->getCountryCodes())->count(4);
        verify($this->paymentMethod->getCountryCodes())->contains('FR');
    }

    /**
     * @return void
     */
    public function testItCanGetSubMethods(): void
    {
        verify($this->paymentMethod->getSubMethods())->isInstanceOf(PaymentMethods::class);
        verify($this->paymentMethod->getSubMethods())->count(0);
    }

    /**
     * @depends testItCanGetSubMethods
     *
     * @return void
     */
    public function testItCanSetSubMethods(): void
    {
        $methods = $this->paymentMethod->getSubMethods();

        expect($this->paymentMethod->setSubMethods(new PaymentMethods()))->isInstanceOf(PaymentMethod::class);

        verify($this->paymentMethod->getSubMethods())->notSame($methods);
    }

    /**
     * @depends testItCanGetSubMethods
     *
     * @return void
     */
    public function testItCanAddSubMethod(): void
    {
        /** @var PaymentMethod $payPalPaymentMethod */
        $payPalPaymentMethod = $this->tester->grabService('modelManager')->get('PaymentMethod');
        $payPalPaymentMethod
            ->setId(138)
            ->setName('PayPal');

        $this->paymentMethod->addSubMethod($payPalPaymentMethod);

        verify($this->paymentMethod->getSubMethods())->count(1);
        verify($this->paymentMethod->getSubMethods())->hasKey($payPalPaymentMethod->getId());
        verify($this->paymentMethod->getSubMethods())->containsOnlyInstancesOf(PaymentMethod::class);
    }
}

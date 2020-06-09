<?php

declare(strict_types=1);

namespace Tests\PayNL\Sdk\unit\Model\Member;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    PaymentMethod,
    Member\PaymentMethodAwareTrait,
    PaymentMethods
};
use UnitTester,
    ReflectionException;

/**
 * Class PaymentMethodAwareTraitTest
 *
 * @package Tests\PayNL\Sdk\unit\Model\Member
 */
class PaymentMethodAwareTraitTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanSetPaymentMethod(): void
    {
        /** @var PaymentMethodAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(PaymentMethodAwareTrait::class);

        $this->tester->assertObjectHasMethod('setPaymentMethod', $traitCls);
        $this->tester->assertObjectMethodIsPublic('setPaymentMethod', $traitCls);

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->tester->grabService('modelManager')->get('PaymentMethod');

        $result = $traitCls->setPaymentMethod($paymentMethod);
        verify($result)->isInstanceOf(get_class($traitCls));
        verify($result)->same($traitCls);
    }

    /**
     * @depends testItCanSetPaymentMethod
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function testItCanGetPaymentMethod(): void
    {
        /** @var PaymentMethodAwareTrait $traitCls */
        $traitCls = $this->getMockForTrait(PaymentMethodAwareTrait::class);

        $this->tester->assertObjectHasMethod('getPaymentMethod', $traitCls);
        $this->tester->assertObjectMethodIsPublic('getPaymentMethod', $traitCls);

        $paymentMethod = $traitCls->getPaymentMethod();
        verify($paymentMethod)->isInstanceOf(PaymentMethod::class);
        verify($paymentMethod->getId())->isEmpty();
        verify($paymentMethod->getSubId())->isEmpty();
        verify($paymentMethod->getName())->isEmpty();
        verify($paymentMethod->getImage())->isEmpty();
        verify($paymentMethod->getCountryCodes())->isEmpty();
        verify($paymentMethod->getSubMethods())->isEmpty();

        /** @var PaymentMethods $paymentMethodsModel */
        $paymentMethodsModel = $this->tester->grabService('modelManager')->get('PaymentMethods');
        $paymentMethodsModel->addPaymentMethod(clone $paymentMethod);

        /** @var PaymentMethod $paymentMethodModel */
        $paymentMethodModel = $this->tester->grabService('modelManager')->get('PaymentMethod');
        $paymentMethodModel->setId(1234);
        $paymentMethodModel->setSubId('foo');
        $paymentMethodModel->setName('bar');
        $paymentMethodModel->setImage('corge.jpg');
        $paymentMethodModel->setCountryCodes(['NL']);
        $paymentMethodModel->setSubMethods($paymentMethodsModel);
        $traitCls->setPaymentMethod($paymentMethodModel);

        $result = $traitCls->getPaymentMethod();
        verify($result)->isInstanceOf(PaymentMethod::class);
        verify($result)->same($paymentMethodModel);
        verify($result)->notSame($paymentMethod);
    }
}

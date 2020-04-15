<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
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
    use ModelTestTrait;

    /**
     * @var PaymentMethod
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new PaymentMethod();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        expect($this->model->setId(10))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $this->tester->assertObjectHasMethod('getId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getId', $this->model);

        $this->model->setId(10);

        verify($this->model->getId())->int();
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->equals(10);
    }

    /**
     * @return void
     */
    public function testItCanSetASubId(): void
    {
        $this->tester->assertObjectHasMethod('setSubId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setSubId', $this->model);

        verify($this->model->setSubId(8))->isInstanceOf(PaymentMethod::class);
        verify($this->model->setSubId('8'))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetASubId
     *
     * @return void
     */
    public function testItCanGetASubId(): void
    {
        $this->tester->assertObjectHasMethod('getSubId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getSubId', $this->model);

        verify($this->model->getSubId())->isEmpty();

        $this->model->setSubId(8);

        verify($this->model->getSubId())->string();
        verify($this->model->getSubId())->notEmpty();
        verify($this->model->getSubId())->equals('8');
    }

    /**
     * @depends testItCanSetASubId
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenSubIdIsNotAStringNorAnInteger(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->model->setSubId(array());
    }

    /**
     * @return void
     */
    public function testItCanSetAName(): void
    {
        $this->tester->assertObjectHasMethod('setName', $this->model);
        $this->tester->assertObjectMethodIsPublic('setName', $this->model);

        expect($this->model->setName('iDeal'))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetAName
     *
     * @return void
     */
    public function testItCanGetAName(): void
    {
        $this->tester->assertObjectHasMethod('getName', $this->model);
        $this->tester->assertObjectMethodIsPublic('getName', $this->model);

        $this->model->setName('iDeal');

        verify($this->model->getName())->string();
        verify($this->model->getName())->notEmpty();
        verify($this->model->getName())->equals('iDeal');
    }

    /**
     * @return void
     */
    public function testItCanSetAnImage(): void
    {
        $this->tester->assertObjectHasMethod('setImage', $this->model);
        $this->tester->assertObjectMethodIsPublic('setImage', $this->model);

        expect($this->model->setImage('http://www.pay.nl/link-to-image'))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetAnImage
     *
     * @return void
     */
    public function testItCanGetAnImage(): void
    {
        $this->tester->assertObjectHasMethod('getImage', $this->model);
        $this->tester->assertObjectMethodIsPublic('getImage', $this->model);

        $this->model->setImage('http://www.pay.nl/link-to-image');

        verify($this->model->getImage())->string();
        verify($this->model->getImage())->notEmpty();
        verify($this->model->getImage())->equals('http://www.pay.nl/link-to-image');
    }

    /**
     * @return void
     */
    public function testItCanSetCountryCodes(): void
    {
        $this->tester->assertObjectHasMethod('setCountryCodes', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCountryCodes', $this->model);

        expect($this->model->setCountryCodes([]))->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @depends testItCanSetCountryCodes
     *
     * @return void
     */
    public function testItCanGetCountryCodes(): void
    {
        $this->tester->assertObjectHasMethod('getCountryCodes', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCountryCodes', $this->model);

        $this->model->setCountryCodes([ 'NL', 'BE' ]);

        verify($this->model->getCountryCodes())->array();
        verify($this->model->getCountryCodes())->notEmpty();
        verify($this->model->getCountryCodes())->count(2);
        verify($this->model->getCountryCodes())->contains('NL');
        verify($this->model->getCountryCodes())->contains('BE');
        verify($this->model->getCountryCodes())->containsOnly('string');
    }

    /**
     * @depends testItCanSetCountryCodes
     * @depends testItCanGetCountryCodes
     *
     * @return void
     */
    public function testItCanAddCountryCode(): void
    {
        $this->tester->assertObjectHasMethod('addCountryCode', $this->model);
        $this->tester->assertObjectMethodIsPublic('addCountryCode', $this->model);

        $this->model->setCountryCodes([ 'NL', 'BE', 'DE' ]);

        $this->model->addCountryCode('FR');

        verify($this->model->getCountryCodes())->count(4);
        verify($this->model->getCountryCodes())->contains('FR');
    }

    /**
     * @return void
     */
    public function testItCanGetSubMethods(): void
    {
        $this->tester->assertObjectHasMethod('getSubMethods', $this->model);
        $this->tester->assertObjectMethodIsPublic('getSubMethods', $this->model);

        verify($this->model->getSubMethods())->isInstanceOf(PaymentMethods::class);
        verify($this->model->getSubMethods())->count(0);
    }

    /**
     * @depends testItCanGetSubMethods
     *
     * @return void
     */
    public function testItCanSetSubMethods(): void
    {
        $this->tester->assertObjectHasMethod('setSubMethods', $this->model);
        $this->tester->assertObjectMethodIsPublic('setSubMethods', $this->model);

        $methods = $this->model->getSubMethods();

        expect($this->model->setSubMethods(new PaymentMethods()))->isInstanceOf(PaymentMethod::class);

        verify($this->model->getSubMethods())->notSame($methods);
    }

    /**
     * @depends testItCanGetSubMethods
     *
     * @return void
     */
    public function testItCanAddSubMethod(): void
    {
        $this->tester->assertObjectHasMethod('addSubMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('addSubMethod', $this->model);

        /** @var PaymentMethod $payPalPaymentMethod */
        $payPalPaymentMethod = $this->tester->grabService('modelManager')->get('PaymentMethod');
        $payPalPaymentMethod
            ->setId(138)
            ->setName('PayPal');

        $this->model->addSubMethod($payPalPaymentMethod);

        verify($this->model->getSubMethods())->count(1);
        verify($this->model->getSubMethods())->hasKey($payPalPaymentMethod->getId());
        verify($this->model->getSubMethods())->containsOnlyInstancesOf(PaymentMethod::class);
    }
}

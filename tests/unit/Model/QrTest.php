<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Amount,
    ModelInterface,
    PaymentMethod,
    Qr
};
use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;
use PayNL\Sdk\Exception\InvalidArgumentException;
use UnitTester;

/**
 * Class QrTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class QrTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Qr
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->markAsJsonSerializable();
        $this->model = new Qr();
    }

    /**
     * @return void
     */
    public function testItCanSetAUuid(): void
    {
        $this->tester->assertObjectHasMethod('setUuid', $this->model);
        $this->tester->assertObjectMethodIsPublic('setUuid', $this->model);

        expect($this->model->setUuid('869c9b32-e9a7-11e9-96ef-90b11c281a75'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAUuid
     *
     * @return void
     */
    public function testItCanGetAUuid(): void
    {
        $this->tester->assertObjectHasMethod('getUuid', $this->model);
        $this->tester->assertObjectMethodIsPublic('getUuid', $this->model);

        $this->model->setUuid('869c9b32-e9a7-11e9-96ef-90b11c281a75');

        verify($this->model->getUuid())->string();
        verify($this->model->getUuid())->notEmpty();
        verify($this->model->getUuid())->equals('869c9b32-e9a7-11e9-96ef-90b11c281a75');
    }

    /**
     * @return void
     */
    public function testItCanSetAServiceId(): void
    {
        $this->tester->assertObjectHasMethod('setServiceId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setServiceId', $this->model);

        expect($this->model->setServiceId('SL-0000-0000'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAServiceId
     *
     * @return void
     */
    public function testItCanGetAServiceId(): void
    {
        $this->tester->assertObjectHasMethod('getServiceId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getServiceId', $this->model);

        $this->model->setServiceId('SL-0000-0000');

        verify($this->model->getServiceId())->string();
        verify($this->model->getServiceId())->notEmpty();
        verify($this->model->getServiceId())->equals('SL-0000-0000');
    }

    /**
     * @return void
     */
    public function testItCanSetASecret(): void
    {
        $this->tester->assertObjectHasMethod('setSecret', $this->model);
        $this->tester->assertObjectMethodIsPublic('setSecret', $this->model);

        expect($this->model->setSecret('abcdef0123456789abcdef0123456789abcd0123'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetASecret
     *
     * @return void
     */
    public function testItCanGetASecret(): void
    {
        $this->tester->assertObjectHasMethod('getSecret', $this->model);
        $this->tester->assertObjectMethodIsPublic('getSecret', $this->model);

        $this->model->setSecret('abcdef0123456789abcdef0123456789abcd0123');

        verify($this->model->getSecret())->string();
        verify($this->model->getSecret())->notEmpty();
        verify($this->model->getSecret())->equals('abcdef0123456789abcdef0123456789abcd0123');
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        $this->tester->assertObjectHasMethod('setAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('setAmount', $this->model);

        /** @var Amount $amount */
        $amount = $this->tester->grabService('modelManager')->get('Amount');
        $amount->setAmount(12345);
        verify($this->model->setAmount($amount))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        $this->tester->assertObjectHasMethod('getAmount', $this->model);
        $this->tester->assertObjectMethodIsPublic('getAmount', $this->model);

        /** @var Amount $amount */
        $amount = $this->tester->grabService('modelManager')->get('Amount');
        $amount->setAmount(12345);
        $this->model->setAmount($amount);

        verify($this->model->getAmount())->isInstanceOf(Amount::class);
        verify($this->model->getAmount())->equals($amount);
    }

    /**
     * @return void
     */
    public function testItCanSetAReference(): void
    {
        $this->tester->assertObjectHasMethod('setReference', $this->model);
        $this->tester->assertObjectMethodIsPublic('setReference', $this->model);

        expect($this->model->setReference('ABCD1234'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAReference
     *
     * @return void
     */
    public function testItCanGetAReference(): void
    {
        $this->tester->assertObjectHasMethod('getReference', $this->model);
        $this->tester->assertObjectMethodIsPublic('getReference', $this->model);

        $this->model->setReference('ABCD1234');

        verify($this->model->getReference())->string();
        verify($this->model->getReference())->notEmpty();
        verify($this->model->getReference())->equals('ABCD1234');
    }

    /**
     * @return void
     */
    public function testItCanSetAPadChar(): void
    {
        $this->tester->assertObjectHasMethod('setPadChar', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPadChar', $this->model);

        expect($this->model->setPadChar('A'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAPadChar
     *
     * @return void
     */
    public function testItCanGetAPadChar(): void
    {
        $this->tester->assertObjectHasMethod('getPadChar', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPadChar', $this->model);

        $this->model->setPadChar('A');

        verify($this->model->getPadChar())->string();
        verify($this->model->getPadChar())->notEmpty();
        verify($this->model->getPadChar())->equals('A');
    }

    /**
     * @return void
     */
    public function testItCanSetAReferenceType(): void
    {
        $this->tester->assertObjectHasMethod('setReferenceType', $this->model);
        $this->tester->assertObjectMethodIsPublic('setReferenceType', $this->model);

        expect($this->model->setReferenceType('string'))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionOnInvalidArgumentForReferenceType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->model->setReferenceType('test');
    }

    /**
     * @depends testItCanSetAReferenceType
     *
     * @return void
     */
    public function testItCanGetAReferenceType(): void
    {
        $this->tester->assertObjectHasMethod('getReferenceType', $this->model);
        $this->tester->assertObjectMethodIsPublic('getReferenceType', $this->model);

        $this->model->setReferenceType('string');

        verify($this->model->getReferenceType())->string();
        verify($this->model->getReferenceType())->notEmpty();
        verify($this->model->getReferenceType())->equals('string');
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentMethod(): void
    {
        $this->tester->assertObjectHasMethod('setPaymentMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPaymentMethod', $this->model);

        $paymentMethod = $this->tester->grabService('modelManager')->get('PaymentMethod');
        verify($this->model->setPaymentMethod($paymentMethod))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAPaymentMethod
     *
     * @return void
     */
    public function testItCanGetAPaymentMethod(): void
    {
        $this->tester->assertObjectHasMethod('getPaymentMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPaymentMethod', $this->model);

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->tester->grabService('modelManager')->get('PaymentMethod');
        $paymentMethod->setName('iDeal');
        $this->model->setPaymentMethod($paymentMethod);
        verify($this->model->getPaymentMethod())->equals($paymentMethod);
    }

    /**
     * @return void
     */
    public function testItCanSetAnExternalPaymentLink(): void
    {
        $this->tester->assertObjectHasMethod('setExternalPaymentLink', $this->model);
        $this->tester->assertObjectMethodIsPublic('setExternalPaymentLink', $this->model);

        verify($this->model->setExternalPaymentLink('www.pay.nl'))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItCanGetAnExternalPaymentLink(): void
    {
        $this->tester->assertObjectHasMethod('getExternalPaymentLink', $this->model);
        $this->tester->assertObjectMethodIsPublic('getExternalPaymentLink', $this->model);

        $externalPaymentLink = 'www.pay.nl';
        $this->model->setExternalPaymentLink($externalPaymentLink);
        verify($externalPaymentLink === $this->model->getExternalPaymentLink())->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentLink(): void
    {
        $this->tester->assertObjectHasMethod('setPaymentLink', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPaymentLink', $this->model);

        verify($this->model->setPaymentLink('www.pay.nl'))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItCanGetAPaymentLink(): void
    {
        $this->tester->assertObjectHasMethod('getPaymentLink', $this->model);
        $this->tester->assertObjectMethodIsPublic('getPaymentLink', $this->model);

        $paymentLink = 'www.pay.nl';
        $this->model->setPaymentLink($paymentLink);
        verify($paymentLink === $this->model->getPaymentLink())->true();
    }

    /**
     * @return void
     */
    public function testItCanSetContents(): void
    {
        $this->tester->assertObjectHasMethod('setContents', $this->model);
        $this->tester->assertObjectMethodIsPublic('setContents', $this->model);

        verify($this->model->setContents('12345'))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItCanGetContents(): void
    {
        $this->tester->assertObjectHasMethod('getContents', $this->model);
        $this->tester->assertObjectMethodIsPublic('getContents', $this->model);

        $contents = '12345';
        $this->model->setContents($contents);
        verify($contents === $this->model->getContents())->true();
    }

}

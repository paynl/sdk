<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
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
    /** @var UnitTester */
    protected $tester;

    /**
     * @var Qr
     */
    protected $qr;

    public function _before(): void
    {
        $this->qr = new Qr();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->qr)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItJsonSerializable(): void
    {
        verify($this->qr)->isInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItHasJsonSerializeTrait(): void
    {
        verify(in_array(JsonSerializeTrait::class, class_uses($this->qr), true))->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAUuid(): void
    {
        expect($this->qr->setUuid('869c9b32-e9a7-11e9-96ef-90b11c281a75'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAUuid
     *
     * @return void
     */
    public function testItCanGetAUuid(): void
    {
        $this->qr->setUuid('869c9b32-e9a7-11e9-96ef-90b11c281a75');

        verify($this->qr->getUuid())->string();
        verify($this->qr->getUuid())->notEmpty();
        verify($this->qr->getUuid())->equals('869c9b32-e9a7-11e9-96ef-90b11c281a75');
    }

    /**
     * @return void
     */
    public function testItCanSetAServiceId(): void
    {
        expect($this->qr->setServiceId('SL-0000-0000'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAServiceId
     *
     * @return void
     */
    public function testItCanGetAServiceId(): void
    {
        $this->qr->setServiceId('SL-0000-0000');

        verify($this->qr->getServiceId())->string();
        verify($this->qr->getServiceId())->notEmpty();
        verify($this->qr->getServiceId())->equals('SL-0000-0000');
    }

    /**
     * @return void
     */
    public function testItCanSetASecret(): void
    {
        expect($this->qr->setSecret('abcdef0123456789abcdef0123456789abcd0123'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetASecret
     *
     * @return void
     */
    public function testItCanGetASecret(): void
    {
        $this->qr->setSecret('abcdef0123456789abcdef0123456789abcd0123');

        verify($this->qr->getSecret())->string();
        verify($this->qr->getSecret())->notEmpty();
        verify($this->qr->getSecret())->equals('abcdef0123456789abcdef0123456789abcd0123');
    }

    /**
     * @return void
     */
    public function testItCanSetAnAmount(): void
    {
        /** @var Amount $amount */
        $amount = $this->tester->grabService('modelManager')->get('Amount');
        $amount->setAmount(12345);
        verify($this->qr->setAmount($amount))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAnAmount
     *
     * @return void
     */
    public function testItCanGetAnAmount(): void
    {
        /** @var Amount $amount */
        $amount = $this->tester->grabService('modelManager')->get('Amount');
        $amount->setAmount(12345);
        $this->qr->setAmount($amount);

        verify($this->qr->getAmount())->isInstanceOf(Amount::class);
        verify($this->qr->getAmount())->equals($amount);
    }

    /**
     * @return void
     */
    public function testItCanSetAReference(): void
    {
        expect($this->qr->setReference('ABCD1234'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAReference
     *
     * @return void
     */
    public function testItCanGetAReference(): void
    {
        $this->qr->setReference('ABCD1234');

        verify($this->qr->getReference())->string();
        verify($this->qr->getReference())->notEmpty();
        verify($this->qr->getReference())->equals('ABCD1234');
    }

    /**
     * @return void
     */
    public function testItCanSetAPadChar(): void
    {
        expect($this->qr->setPadChar('A'))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAPadChar
     *
     * @return void
     */
    public function testItCanGetAPadChar(): void
    {
        $this->qr->setPadChar('A');

        verify($this->qr->getPadChar())->string();
        verify($this->qr->getPadChar())->notEmpty();
        verify($this->qr->getPadChar())->equals('A');
    }

    /**
     * @return void
     */
    public function testItCanSetAReferenceType(): void
    {
        expect($this->qr->setReferenceType('string'))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionOnInvalidArgumentForReferenceType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->qr->setReferenceType('test');
    }

    /**
     * @depends testItCanSetAReferenceType
     *
     * @return void
     */
    public function testItCanGetAReferenceType(): void
    {
        $this->qr->setReferenceType('string');

        verify($this->qr->getReferenceType())->string();
        verify($this->qr->getReferenceType())->notEmpty();
        verify($this->qr->getReferenceType())->equals('string');
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentMethod(): void
    {
        $paymentMethod = $this->tester->grabService('modelManager')->get('PaymentMethod');
        verify($this->qr->setPaymentMethod($paymentMethod))->isInstanceOf(Qr::class);
    }

    /**
     * @depends testItCanSetAPaymentMethod
     *
     * @return void
     */
    public function testItCanGetAPaymentMethod(): void
    {
        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $this->tester->grabService('modelManager')->get('PaymentMethod');
        $paymentMethod->setName('iDeal');
        $this->qr->setPaymentMethod($paymentMethod);
        verify($this->qr->getPaymentMethod())->equals($paymentMethod);
    }

    /**
     * @return void
     */
    public function testItCanSetAnExternalPaymentLink(): void
    {
        verify($this->qr->setExternalPaymentLink('www.pay.nl'))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItCanGetAnExternalPaymentLink(): void
    {
        $externalPaymentLink = 'www.pay.nl';
        $this->qr->setExternalPaymentLink($externalPaymentLink);
        verify($externalPaymentLink === $this->qr->getExternalPaymentLink())->true();
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentLink(): void
    {
        verify($this->qr->setPaymentLink('www.pay.nl'))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItCanGetAPaymentLink(): void
    {
        $paymentLink = 'www.pay.nl';
        $this->qr->setPaymentLink($paymentLink);
        verify($paymentLink === $this->qr->getPaymentLink())->true();
    }

    /**
     * @return void
     */
    public function testItCanSetContents(): void
    {
        verify($this->qr->setContents('12345'))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItCanGetContents(): void
    {
        $contents = '12345';
        $this->qr->setContents($contents);
        verify($contents === $this->qr->getContents())->true();
    }

}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\{
    Lib\ModelTestTrait,
    Test\Unit as UnitTest
};
use PayNL\Sdk\Model\{
    Card,
    PaymentMethod,
    Receipt
};

/**
 * Class ReceiptTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ReceiptTest extends UnitTest
{
    use ModelTestTrait;

    /**
     * @var Receipt
     */
    protected $model;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->model = new Receipt();
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $this->tester->assertObjectHasMethod('setId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setId', $this->model);

        $id = 'TG9yZW0lMjBpcHN1bSUyMGRvbG9yJTIwc2l0JTIwYW1ldCwlMjBjb25zZWN0ZXR1ciUyMGFkaXBpc2NpbmclMjBlbGl0Lg==';

        verify($this->model->setId($id))->isInstanceOf(Receipt::class);
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

        $id = 'TG9yZW0lMjBpcHN1bSUyMGRvbG9yJTIwc2l0JTIwYW1ldCwlMjBjb25zZWN0ZXR1ciUyMGFkaXBpc2NpbmclMjBlbGl0Lg==';

        $this->model->setId($id);

        verify($this->model->getId())->string();
        verify($this->model->getId())->notEmpty();
        verify($this->model->getId())->equals($id);
    }

    /**
     * @return void
     */
    public function testItCanSetASignature(): void
    {
        $this->tester->assertObjectHasMethod('setSignature', $this->model);
        $this->tester->assertObjectMethodIsPublic('setSignature', $this->model);

        expect($this->model->setSignature('esfjrherNQEWRN8uSDbD*$Rb8iu'))->isInstanceOf(Receipt::class);
    }

    /**
     * @depends testItCanSetASignature
     *
     * @return void
     */
    public function testItCanGetASignature(): void
    {
        $this->tester->assertObjectHasMethod('getSignature', $this->model);
        $this->tester->assertObjectMethodIsPublic('getSignature', $this->model);

        $this->model->setSignature('esfjrherNQEWRN8uSDbD*$Rb8iu');

        verify($this->model->getSignature())->string();
        verify($this->model->getSignature())->notEmpty();
        verify($this->model->getSignature())->equals('esfjrherNQEWRN8uSDbD*$Rb8iu');
    }

    /**
     * @return void
     */
    public function testItCanSetAnApprovalId(): void
    {
        $this->tester->assertObjectHasMethod('setApprovalId', $this->model);
        $this->tester->assertObjectMethodIsPublic('setApprovalId', $this->model);

        expect($this->model->setApprovalId('Hd8sa39934'))->isInstanceOf(Receipt::class);
    }

    /**
     * @depends testItCanSetAnApprovalId
     *
     * @return void
     */
    public function testItCanGetAnApprovalId(): void
    {
        $this->tester->assertObjectHasMethod('getApprovalId', $this->model);
        $this->tester->assertObjectMethodIsPublic('getApprovalId', $this->model);

        $this->model->setApprovalId('Hd8sa39934');

        verify($this->model->getApprovalId())->string();
        verify($this->model->getApprovalId())->notEmpty();
        verify($this->model->getApprovalId())->equals('Hd8sa39934');
    }

    /**
     * @return void
     */
    public function testItCanSetACard(): void
    {
        $this->tester->assertObjectHasMethod('setCard', $this->model);
        $this->tester->assertObjectMethodIsPublic('setCard', $this->model);

        /** @var Card $card */
        $card = $this->tester->grabService('modelManager')->get('Card');
        verify($this->model->setCard($card))->isInstanceOf(Receipt::class);
    }

    /**
     * @depends testItCanSetACard
     *
     * @return void
     */
    public function testItCanGetACard(): void
    {
        $this->tester->assertObjectHasMethod('getCard', $this->model);
        $this->tester->assertObjectMethodIsPublic('getCard', $this->model);

        $card = $this->model->getCard();
        verify($card)->isInstanceOf(Card::class);

        /** @var Card $cardMock */
        $cardMock = $this->tester->grabService('modelManager')->get('Card');
        $cardMock->setName('Visa');
        $this->model->setCard($cardMock);

        verify($this->model->getCard())->notEmpty();
        verify($this->model->getCard())->isInstanceOf(Card::class);
        verify($this->model->getCard())->equals($cardMock);
        verify($this->model->getCard())->notSame($card);
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentMethod(): void
    {
        $this->tester->assertObjectHasMethod('setPaymentMethod', $this->model);
        $this->tester->assertObjectMethodIsPublic('setPaymentMethod', $this->model);

        $paymentMethodMock = $this->tester->grabService('modelManager')->get('PaymentMethod');
        expect($this->model->setPaymentMethod($paymentMethodMock))->isInstanceOf(Receipt::class);
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

        $paymentMethodMock = $this->tester->grabService('modelManager')->get('PaymentMethod');
        $this->model->setPaymentMethod($paymentMethodMock);

        verify($this->model->getPaymentMethod())->notEmpty();
        verify($this->model->getPaymentMethod())->isInstanceOf(PaymentMethod::class);
    }
}

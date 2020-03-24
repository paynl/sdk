<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Model;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Model\{
    ModelInterface,
    Card,
    PaymentMethod,
    Receipt
};
use JsonSerializable;
use UnitTester;

/**
 * Class ReceiptTest
 *
 * @package Tests\Unit\PayNL\Sdk\Model
 */
class ReceiptTest extends UnitTest
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @var Receipt
     */
    protected $receipt;

    public function _before(): void
    {
        $this->receipt = new Receipt();
    }

    /**
     * @return void
     */
    public function testItIsAModel(): void
    {
        verify($this->receipt)->isInstanceOf(ModelInterface::class);
    }

    /**
     * @return void
     */
    public function testIsItNotJsonSerializable(): void
    {
        verify($this->receipt)->isNotInstanceOf(JsonSerializable::class);
    }

    /**
     * @return void
     */
    public function testItCanSetAnId(): void
    {
        $id = 'TG9yZW0lMjBpcHN1bSUyMGRvbG9yJTIwc2l0JTIwYW1ldCwlMjBjb25zZWN0ZXR1ciUyMGFkaXBpc2NpbmclMjBlbGl0Lg==';

        verify($this->receipt->setId($id))->isInstanceOf(Receipt::class);
    }

    /**
     * @depends testItCanSetAnId
     *
     * @return void
     */
    public function testItCanGetAnId(): void
    {
        $id = 'TG9yZW0lMjBpcHN1bSUyMGRvbG9yJTIwc2l0JTIwYW1ldCwlMjBjb25zZWN0ZXR1ciUyMGFkaXBpc2NpbmclMjBlbGl0Lg==';

        $this->receipt->setId($id);

        verify($this->receipt->getId())->string();
        verify($this->receipt->getId())->notEmpty();
        verify($this->receipt->getId())->equals($id);
    }

    /**
     * @return void
     */
    public function testItCanSetASignature(): void
    {
        expect($this->receipt->setSignature('esfjrherNQEWRN8uSDbD*$Rb8iu'))->isInstanceOf(Receipt::class);
    }

    /**
     * @depends testItCanSetASignature
     *
     * @return void
     */
    public function testItCanGetASignature(): void
    {
        $this->receipt->setSignature('esfjrherNQEWRN8uSDbD*$Rb8iu');

        verify($this->receipt->getSignature())->string();
        verify($this->receipt->getSignature())->notEmpty();
        verify($this->receipt->getSignature())->equals('esfjrherNQEWRN8uSDbD*$Rb8iu');
    }

    /**
     * @return void
     */
    public function testItCanSetAnApprovalId(): void
    {
        expect($this->receipt->setApprovalId('Hd8sa39934'))->isInstanceOf(Receipt::class);
    }

    /**
     * @depends testItCanSetAnApprovalId
     *
     * @return void
     */
    public function testItCanGetAnApprovalId(): void
    {
        $this->receipt->setApprovalId('Hd8sa39934');

        verify($this->receipt->getApprovalId())->string();
        verify($this->receipt->getApprovalId())->notEmpty();
        verify($this->receipt->getApprovalId())->equals('Hd8sa39934');
    }

    /**
     * @return void
     */
    public function testItCanSetACard(): void
    {
        /** @var Card $card */
        $card = $this->tester->grabService('modelManager')->get('Card');
        verify($this->receipt->setCard($card))->isInstanceOf(Receipt::class);
    }

    /**
     * @depends testItCanSetACard
     *
     * @return void
     */
    public function testItCanGetACard(): void
    {
        /** @var Card $cardMock */
        $cardMock = $this->tester->grabService('modelManager')->get('Card');
        $cardMock->setName('Visa');
        $this->receipt->setCard($cardMock);

        verify($this->receipt->getCard())->notEmpty();
        verify($this->receipt->getCard())->isInstanceOf(Card::class);
        verify($this->receipt->getCard())->equals($cardMock);
    }

    /**
     * @return void
     */
    public function testItCanSetAPaymentMethod(): void
    {
        $paymentMethodMock = $this->tester->grabService('modelManager')->get('PaymentMethod');
        expect($this->receipt->setPaymentMethod($paymentMethodMock))->isInstanceOf(Receipt::class);
    }

    /**
     * @depends testItCanSetAPaymentMethod
     *
     * @return void
     */
    public function testItCanGetAPaymentMethod(): void
    {
        $paymentMethodMock = $this->tester->grabService('modelManager')->get('PaymentMethod');
        $this->receipt->setPaymentMethod($paymentMethodMock);

        verify($this->receipt->getPaymentMethod())->notEmpty();
        verify($this->receipt->getPaymentMethod())->isInstanceOf(PaymentMethod::class);
    }
}

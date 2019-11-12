<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Model\{
    Card,
    PaymentMethod,
    Receipt
};
use Zend\Hydrator\HydratorInterface;
use PayNL\Sdk\Hydrator\Receipt as ReceiptHydrator;

/**
 * Class ReceiptTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 *
 */
class ReceiptTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new ReceiptHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAReceiptModel(): void
    {
        $hydrator = new ReceiptHydrator();
        expect($hydrator->hydrate([], new Receipt()))->isInstanceOf(Receipt::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new ReceiptHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $id = 'UE9JOiA5MDAwMDAwMQpLTEFOVFRJQ0tFVAotLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KC' .
            'gpNZXJjaGFudE5hbWUKVXRyZWNodCBDZW50cnVtCk5ldyBLYXNzYQpUZXJtaW5hbDogQTFCMDBDIE1lcmNoYW50OiAxMDAwMDAKUGVy' .
            'aW9kZTogMTAwMCBUcmFuc2FjdGllOiAwMTAwMDAwMQoKTWFlc3RybwoKCgpLYWFydDogeHh4eHh4eHh4eHh4eHh4MDAwMAoKS2FhcnR' .
            'zZXJpZW51bW1lcjogMDEKCkJFVEFMSU5HIApEYXR1bTogMDcvMTAvMjAxOSAwMDowMQoKQXV0b3Jpc2F0aWVjb2RlOiBCMDAwMDAKCl' .
            'RvdGFhbDogMCwwMSBFVVIKCkxlZXNtZXRob2RlOiBORkMgQ2hpcAoKCkJFREFOS1QKVE9UIFpJRU5TCgo='
        ;

        $hydrator = new ReceiptHydrator();
        $receipt = $hydrator->hydrate([
            'id'            => $id,
            'signature'     => false,
            'approvalId'    => 'B00000',
            'card'          => [
                'id'   => 1009,
                'name' => 'Maestro'
            ],
            'paymentMethod' => [
                'id'   => 1630,
                'name' => 'Pin (Maestro)',
            ],
        ], new Receipt());

        expect($receipt->getId())->string();
        expect($receipt->getId())->equals($id);
        expect($receipt->getSignature())->string();
        expect($receipt->getSignature())->equals('');
        expect($receipt->getApprovalId())->string();
        expect($receipt->getApprovalId())->equals('B00000');
        expect($receipt->getCard())->isInstanceOf(Card::class);
        expect($receipt->getPaymentMethod())->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $id = 'UE9JOiA5MDAwMDAwMQpLTEFOVFRJQ0tFVAotLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0KC' .
            'gpNZXJjaGFudE5hbWUKVXRyZWNodCBDZW50cnVtCk5ldyBLYXNzYQpUZXJtaW5hbDogQTFCMDBDIE1lcmNoYW50OiAxMDAwMDAKUGVy' .
            'aW9kZTogMTAwMCBUcmFuc2FjdGllOiAwMTAwMDAwMQoKTWFlc3RybwoKCgpLYWFydDogeHh4eHh4eHh4eHh4eHh4MDAwMAoKS2FhcnR' .
            'zZXJpZW51bW1lcjogMDEKCkJFVEFMSU5HIApEYXR1bTogMDcvMTAvMjAxOSAwMDowMQoKQXV0b3Jpc2F0aWVjb2RlOiBCMDAwMDAKCl' .
            'RvdGFhbDogMCwwMSBFVVIKCkxlZXNtZXRob2RlOiBORkMgQ2hpcAoKCkJFREFOS1QKVE9UIFpJRU5TCgo='
        ;

        $hydrator = new ReceiptHydrator();
        $receipt = $hydrator->hydrate([
            'id'            => $id,
            'signature'     => false,
            'approvalId'    => 'B00000',
            'card'          => [
                'id'   => 1009,
                'name' => 'Maestro'
            ],
            'paymentMethod' => [
                'id'   => 1630,
                'name' => 'Pin (Maestro)',
            ],
        ], new Receipt());

        $data = $hydrator->extract($receipt);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('signature');
        verify($data)->hasKey('approvalId');
        verify($data)->hasKey('card');
        verify($data)->hasKey('paymentMethod');

        expect($data['id'])->string();
        expect($data['id'])->equals($id);
        expect($data['signature'])->string();
        expect($data['signature'])->equals('');
        expect($data['approvalId'])->string();
        expect($data['approvalId'])->equals('B00000');
        expect($data['card'])->isInstanceOf(Card::class);
        expect($data['paymentMethod'])->isInstanceOf(PaymentMethod::class);
    }
}

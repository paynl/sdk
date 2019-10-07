<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use Zend\Hydrator\HydratorInterface;
use PayNL\Sdk\Hydrator\Qr as QrHydrator;
use PayNL\Sdk\Model\{
    PaymentMethod,
    Qr
};

/**
 * Class QrTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 *
 */
class QrTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new QrHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAQrModel(): void
    {
        $hydrator = new QrHydrator();
        expect($hydrator->hydrate([], new Qr()))->isInstanceOf(Qr::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new QrHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new QrHydrator();
        $qr = $hydrator->hydrate([
            'uuid'          => '441d88c9-e8da-11e9-96ef-90b11c281a75',
            'serviceId'     => 'SL-1000-0001',
            'secret'        => 'abcdef0123456789abcdef0123456789abcd0123',
            'reference'     => 'ABCD1234',
            'padChar'       => '0',
            'referenceType' => 'string',
            'paymentMethod' => [
                'id'   => 10,
                'name' => 'iDeal',
            ],
        ], new Qr());

        expect($qr->getUuid())->string();
        expect($qr->getUuid())->equals('441d88c9-e8da-11e9-96ef-90b11c281a75');
        expect($qr->getServiceId())->string();
        expect($qr->getServiceId())->equals('SL-1000-0001');
        expect($qr->getSecret())->string();
        expect($qr->getSecret())->equals('abcdef0123456789abcdef0123456789abcd0123');
        expect($qr->getReference())->string();
        expect($qr->getReference())->equals('ABCD1234');
        expect($qr->getPadChar())->string();
        expect($qr->getPadChar())->equals('0');
        expect($qr->getReferenceType())->string();
        expect($qr->getReferenceType())->equals('string');
        expect($qr->getPaymentMethod())->isInstanceOf(PaymentMethod::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new QrHydrator();
        $qr = $hydrator->hydrate([
            'uuid'          => '441d88c9-e8da-11e9-96ef-90b11c281a75',
            'serviceId'     => 'SL-1000-0001',
            'secret'        => 'abcdef0123456789abcdef0123456789abcd0123',
            'reference'     => 'ABCD1234',
            'padChar'       => '0',
            'referenceType' => 'string',
            'paymentMethod' => [
                'id'   => 10,
                'name' => 'iDeal',
            ],
        ], new Qr());

        $data = $hydrator->extract($qr);
        $this->assertIsArray($data);
        verify($data)->hasKey('uuid');
        verify($data)->hasKey('serviceId');
        verify($data)->hasKey('secret');
        verify($data)->hasKey('reference');
        verify($data)->hasKey('padChar');
        verify($data)->hasKey('referenceType');
        verify($data)->hasKey('paymentMethod');

        expect($data['uuid'])->string();
        expect($data['uuid'])->equals('441d88c9-e8da-11e9-96ef-90b11c281a75');
        expect($data['serviceId'])->string();
        expect($data['serviceId'])->equals('SL-1000-0001');
        expect($data['secret'])->string();
        expect($data['secret'])->equals('abcdef0123456789abcdef0123456789abcd0123');
        expect($data['reference'])->string();
        expect($data['reference'])->equals('ABCD1234');
        expect($data['padChar'])->string();
        expect($data['padChar'])->equals('0');
        expect($data['referenceType'])->string();
        expect($data['referenceType'])->equals('string');
        expect($data['paymentMethod'])->isInstanceOf(PaymentMethod::class);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\Voucher as VoucherHydrator;
use PayNL\Sdk\Model\{
    Amount,
    Voucher
};
use Zend\Hydrator\HydratorInterface;

/**
 * Class VoucherTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class VoucherTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new VoucherHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAVoucherModel(): void
    {
        $hydrator = new VoucherHydrator();
        expect($hydrator->hydrate([], new Voucher()))->isInstanceOf(Voucher::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new VoucherHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new VoucherHydrator();
        $voucher = $hydrator->hydrate([
            'amount'  => [
                'amount'   => 100,
                'currency' => 'EUR',
            ],
            'pinCode' => '12345',
            'posId'   => '1000',
        ], new Voucher());

        expect($voucher->getAmount())->isInstanceOf(Amount::class);
        expect($voucher->getPinCode())->string();
        expect($voucher->getPinCode())->equals('12345');
        expect($voucher->getPosId())->string();
        expect($voucher->getPosId())->equals('1000');
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new VoucherHydrator();
        $voucher = $hydrator->hydrate([
            'amount'  => [
                'amount'   => 100,
                'currency' => 'EUR',
            ],
            'pinCode' => '12345',
            'posId'   => '1000',
        ], new Voucher());

        $data = $hydrator->extract($voucher);
        $this->assertIsArray($data);
        verify($data)->hasKey('amount');
        verify($data)->hasKey('pinCode');
        verify($data)->hasKey('posId');

        expect($data['amount'])->isInstanceOf(Amount::class);
        expect($data['pinCode'])->string();
        expect($data['pinCode'])->equals('12345');
        expect($data['posId'])->string();
        expect($data['posId'])->equals('1000');
    }
}

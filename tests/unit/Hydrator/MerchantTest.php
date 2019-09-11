<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\{
    Merchant as MerchantHydrator,
    BankAccount as BankAccountHydrator,
    Address as AddressHydrator
};
use PayNL\Sdk\Model\{
    Merchant,
    BankAccount,
    Address
};
use Zend\Hydrator\HydratorInterface;

/**
 * Class MerchantTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 *
 * TODO: finish test
 */
class MerchantTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new MerchantHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldOnlyAcceptSpecificModel(): void
    {
        $hydrator = new MerchantHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new Merchant()))->isInstanceOf(Merchant::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
//        $hydrator = new MerchantHydrator();
//        $merchant = $hydrator->hydrate([
//        ], new Merchant());
//
//        expect($merchant->getInitials())->equals('M');
    }

    public function testItCanExtract(): void
    {
//        $hydrator = new MerchantHydrator();
//        $merchant = $hydrator->hydrate([
//        ], new Merchant());
//
//        $data = $hydrator->extract($merchant);
//        $this->assertIsArray($data);
//        verify($data)->hasKey('initials');
//
//        expect($data['initials'])->equals('M');
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\ServicePaymentLink as ServicePaymentLinkHydrator;
use PayNL\Sdk\Model\{
    Amount,
    ServicePaymentLink,
    Statistics
};
use Zend\Hydrator\HydratorInterface;

/**
 * Class ServicePaymentLinkTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class ServicePaymentLinkTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new ServicePaymentLinkHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldAcceptAServicePaymentLinkModel(): void
    {
        $hydrator = new ServicePaymentLinkHydrator();
        expect($hydrator->hydrate([], new ServicePaymentLink()))->isInstanceOf(ServicePaymentLink::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new ServicePaymentLinkHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new ServicePaymentLinkHydrator();
        $service = $hydrator->hydrate([
            'securityMode' => 1,
            'amount'       => [
                'amount'   => 1,
                'currency' => 'EUR',
            ],
            'amountMin'    => [
                'amount'   => 1,
                'currency' => 'EUR',
            ],
            'countryCode'  => 'NL',
            'language'     => 'nl',
            'statistics'   => [
                'promoterId' => 0,
                'info'       => 'Information',
                'tool'       => 'WEB',
            ],
        ], new ServicePaymentLink());

        expect($service->getSecurityMode())->int();
        expect($service->getSecurityMode())->equals(1);
        expect($service->getAmount())->isInstanceOf(Amount::class);
        expect($service->getAmountMin())->isInstanceOf(Amount::class);
        expect($service->getCountryCode())->string();
        expect($service->getCountryCode())->equals('NL');
        expect($service->getLanguage())->string();
        expect($service->getLanguage())->equals('nl');
        expect($service->getStatistics())->isInstanceOf(Statistics::class);
    }

    /**
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new ServicePaymentLinkHydrator();
        $service = $hydrator->hydrate([
            'securityMode' => 1,
            'amount'       => [
                'amount'   => 1,
                'currency' => 'EUR',
            ],
            'amountMin'    => [
                'amount'   => 1,
                'currency' => 'EUR',
            ],
            'countryCode'  => 'NL',
            'language'     => 'nl',
            'statistics'   => [
                'promoterId' => 0,
                'info'       => 'Information',
                'tool'       => 'WEB',
            ],
        ], new ServicePaymentLink());

        $data = $hydrator->extract($service);
        $this->assertIsArray($data);
        verify($data)->hasKey('securityMode');
        verify($data)->hasKey('amount');
        verify($data)->hasKey('amountMin');
        verify($data)->hasKey('countryCode');
        verify($data)->hasKey('language');
        verify($data)->hasKey('statistics');

        expect($data['securityMode'])->int();
        expect($data['securityMode'])->equals(1);
        expect($data['amount'])->isInstanceOf(Amount::class);
        expect($data['amountMin'])->isInstanceOf(Amount::class);
        expect($data['countryCode'])->string();
        expect($data['countryCode'])->equals('NL');
        expect($data['language'])->string();
        expect($data['language'])->equals('nl');
        expect($data['statistics'])->isInstanceOf(Statistics::class);
    }
}

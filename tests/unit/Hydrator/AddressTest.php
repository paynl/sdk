<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\Address as AddressHydrator;
use PayNL\Sdk\Model\Address;
use Zend\Hydrator\HydratorInterface;

/**
 * Class AddressTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
 */
class AddressTest extends UnitTest
{
    /**
     * @return void
     */
    public function testItIsAHydrator(): void
    {
        $hydrator = new AddressHydrator();
        verify($hydrator)->isInstanceOf(HydratorInterface::class);
    }

    /**
     * @return void
     */
    public function testItShouldOnlyAcceptSipUriObjects(): void
    {
        $hydrator = new AddressHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());

        expect($hydrator->hydrate([], new Address()))->isInstanceOf(Address::class);
    }

    /**
     * @return void
     */
    public function testItShouldCorrectlyFillAddressModel(): void
    {
        $hydrator = new AddressHydrator();
        $address = $hydrator->hydrate([
            'initials'              => 'I',
            'lastName'              => 'Sneep',
            'streetName'            => 'Jan Campertlaan',
            'streetNumber'          => '10',
            'streetNumberExtension' => '',
            'zipCode'               => '3201AX',
            'city'                  => 'Spijkenisse',
            'regionCode'            => 'Zuid-Holland',
            'countryCode'           => 'NL',
        ], new Address());

        expect($address->getInitials())->equals('I');
        expect($address->getLastName())->equals('Sneep');
        expect($address->getStreetName())->equals('Jan Campertlaan');
        expect($address->getStreetNumber())->equals('10');
        expect($address->getStreetNumberExtension())->equals('');
        expect($address->getZipCode())->equals('3201AX');
        expect($address->getCity())->equals('Spijkenisse');
        expect($address->getRegionCode())->equals('Zuid-Holland');
        expect($address->getCountryCode())->equals('NL');
    }

    public function testItCanExtract(): void
    {
        $hydrator = new AddressHydrator();
        $address = $hydrator->hydrate([
            'initials'              => 'I',
            'lastName'              => 'Sneep',
            'streetName'            => 'Jan Campertlaan',
            'streetNumber'          => '10',
            'streetNumberExtension' => '',
            'zipCode'               => '3201AX',
            'city'                  => 'Spijkenisse',
            'regionCode'            => 'Zuid-Holland',
            'countryCode'           => 'NL',
        ], new Address());

        $data = $hydrator->extract($address);
        $this->assertIsArray($data);
        verify($data)->hasKey('initials');
        verify($data)->hasKey('lastName');
        verify($data)->hasKey('streetName');
        verify($data)->hasKey('streetNumber');
        verify($data)->hasKey('streetNumberExtension');
        verify($data)->hasKey('zipCode');
        verify($data)->hasKey('city');
        verify($data)->hasKey('regionCode');
        verify($data)->hasKey('countryCode');

        expect($data['initials'])->equals('I');
        expect($data['lastName'])->equals('Sneep');
        expect($data['streetName'])->equals('Jan Campertlaan');
        expect($data['streetNumber'])->equals('10');
        expect($data['streetNumberExtension'])->equals('');
        expect($data['zipCode'])->equals('3201AX');
        expect($data['city'])->equals('Spijkenisse');
        expect($data['regionCode'])->equals('Zuid-Holland');
        expect($data['countryCode'])->equals('NL');
    }
}

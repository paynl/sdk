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
    public function testItShouldAcceptAnAddressModel(): void
    {
        $hydrator = new AddressHydrator();
        expect($hydrator->hydrate([], new Address()))->isInstanceOf(Address::class);
    }

    /**
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new AddressHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @depends testItShouldAcceptAnAddressModel
     * @depends testItThrowsAnExceptionWhenAWrongInstanceGiven
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
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
            'regionCode'            => 'ZH',
            'countryCode'           => 'NL',
        ], new Address());

        expect($address->getInitials())->string();
        expect($address->getInitials())->equals('I');
        expect($address->getLastName())->string();
        expect($address->getLastName())->equals('Sneep');
        expect($address->getStreetName())->string();
        expect($address->getStreetName())->equals('Jan Campertlaan');
        expect($address->getStreetNumber())->string();
        expect($address->getStreetNumber())->equals('10');
        expect($address->getStreetNumberExtension())->string();
        expect($address->getStreetNumberExtension())->equals('');
        expect($address->getZipCode())->string();
        expect($address->getZipCode())->equals('3201AX');
        expect($address->getCity())->string();
        expect($address->getCity())->equals('Spijkenisse');
        expect($address->getRegionCode())->string();
        expect($address->getRegionCode())->equals('ZH');
        expect($address->getCountryCode())->string();
        expect($address->getCountryCode())->equals('NL');
    }

    /**
     * @depends testItShouldAcceptAnAddressModel
     * @depends testItThrowsAnExceptionWhenAWrongInstanceGiven
     *
     * @return void
     */
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
            'regionCode'            => 'ZH',
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

        expect($data['initials'])->string();
        expect($data['initials'])->equals('I');
        expect($data['lastName'])->string();
        expect($data['lastName'])->equals('Sneep');
        expect($data['streetName'])->string();
        expect($data['streetName'])->equals('Jan Campertlaan');
        expect($data['streetNumber'])->string();
        expect($data['streetNumber'])->equals('10');
        expect($data['streetNumberExtension'])->string();
        expect($data['streetNumberExtension'])->equals('');
        expect($data['zipCode'])->string();
        expect($data['zipCode'])->equals('3201AX');
        expect($data['city'])->string();
        expect($data['city'])->equals('Spijkenisse');
        expect($data['regionCode'])->string();
        expect($data['regionCode'])->equals('ZH');
        expect($data['countryCode'])->string();
        expect($data['countryCode'])->equals('NL');
    }
}

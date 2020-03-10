<?php

declare(strict_types=1);

namespace Tests\Unit\PayNL\Sdk\Hydrator;

use Codeception\Test\Unit as UnitTest;
use PayNL\Sdk\{
    DateTime,
    Exception\InvalidArgumentException,
    Hydrator\Merchant as MerchantHydrator
};
use PayNL\Sdk\Model\{
    ContactMethod,
    Links,
    Merchant,
    BankAccount,
    Address,
    Trademark
};
use Zend\Hydrator\HydratorInterface;
use Exception;

/**
 * Class MerchantTest
 *
 * @package Tests\Unit\PayNL\Sdk\Hydrator
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
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldAcceptAMerchantModel(): void
    {
        $hydrator = new MerchantHydrator();
        expect($hydrator->hydrate([], new Merchant()))->isInstanceOf(Merchant::class);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenAWrongInstanceGiven(): void
    {
        $hydrator = new MerchantHydrator();

        $this->expectException(InvalidArgumentException::class);
        $hydrator->hydrate([], new \stdClass());
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItShouldCorrectlyFillModel(): void
    {
        $hydrator = new MerchantHydrator();
        $merchant = $hydrator->hydrate([
            'id'             => 'M-1000-0001',
            'name'           => 'Pay.nl',
            'coc'            => '24283498',
            'vat'            => 'NL807960147B01',
            'website'        => 'http://www.pay.nl',
            'bankAccount'    => [
                'iban'  => 'NL32RABO1670475085',
                'bic'   => 'RABONL2U',
                'owner' => 'TinTel BV',
            ],
            'postalAddress'  => [
                'initials'              => 'C',
                'lastName'              => 'Kent',
                'streetName'            => 'Jan Campertlaan',
                'streetNumber'          => 10,
                'streetNumberExtension' => '',
                'zipCode'               => '3201 AX',
                'city'                  => 'Spijkenisse',
                'regionCode'            => 'ZH',
                'countryCode'           => 'NL',
            ],
            'visitAddress'   => [
                'initials'              => 'C',
                'lastName'              => 'Kent',
                'streetName'            => 'Jan Campertlaan',
                'streetNumber'          => 10,
                'streetNumberExtension' => '',
                'zipCode'               => '3201 AX',
                'city'                  => 'Spijkenisse',
                'regionCode'            => 'ZH',
                'countryCode'           => 'NL',
            ],
            'trademarks'     => [
                [
                    'id'        => 'PAY.',
                    'trademark' => 'TM-1234-1234',
                ],
            ],
            'contactMethods' => [
                [
                    'type'        => 'email',
                    'value'       => 'support@pay.nl',
                    'description' => 'Support desk',
                ],
            ],
            'createdAt'      => DateTime::createFromFormat(DateTime::ATOM, '2007-09-10T13:26:26+02:00'),
            '_links' => [
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'https://www.pay.nl/get-merchant'
                ]
            ],
        ], new Merchant());

        expect($merchant->getId())->string();
        expect($merchant->getId())->equals('M-1000-0001');
        expect($merchant->getName())->string();
        expect($merchant->getName())->equals('Pay.nl');
        expect($merchant->getCoc())->string();
        expect($merchant->getCoc())->equals('24283498');
        expect($merchant->getVat())->string();
        expect($merchant->getVat())->equals('NL807960147B01');
        expect($merchant->getWebsite())->string();
        expect($merchant->getWebsite())->equals('http://www.pay.nl');
        expect($merchant->getBankAccount())->isInstanceOf(BankAccount::class);
        expect($merchant->getPostalAddress())->isInstanceOf(Address::class);
        expect($merchant->getVisitAddress())->isInstanceOf(Address::class);
        expect($merchant->getTrademarks())->array();
        expect($merchant->getTrademarks())->count(1);
        expect($merchant->getTrademarks())->containsOnlyInstancesOf(Trademark::class);
        expect($merchant->getContactMethods())->array();
        expect($merchant->getContactMethods())->count(1);
        expect($merchant->getContactMethods())->containsOnlyInstancesOf(ContactMethod::class);
        expect($merchant->getCreatedAt())->isInstanceOf(DateTime::class);
        expect($merchant->getLinks())->isInstanceOf(Links::class);
        expect($merchant->getLinks()->count())->equals(1);
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    public function testItCanExtract(): void
    {
        $hydrator = new MerchantHydrator();
        $merchant = $hydrator->hydrate([
            'id'             => 'M-1000-0001',
            'name'           => 'Pay.nl',
            'coc'            => '24283498',
            'vat'            => 'NL807960147B01',
            'website'        => 'http://www.pay.nl',
            'bankAccount'    => [
                'iban'  => 'NL32RABO1670475085',
                'bic'   => 'RABONL2U',
                'owner' => 'TinTel BV',
            ],
            'postalAddress'  => [
                'initials'              => 'C',
                'lastName'              => 'Kent',
                'streetName'            => 'Jan Campertlaan',
                'streetNumber'          => 10,
                'streetNumberExtension' => '',
                'zipCode'               => '3201 AX',
                'city'                  => 'Spijkenisse',
                'regionCode'            => 'ZH',
                'countryCode'           => 'NL',
            ],
            'visitAddress'   => [
                'initials'              => 'C',
                'lastName'              => 'Kent',
                'streetName'            => 'Jan Campertlaan',
                'streetNumber'          => 10,
                'streetNumberExtension' => '',
                'zipCode'               => '3201 AX',
                'city'                  => 'Spijkenisse',
                'regionCode'            => 'ZH',
                'countryCode'           => 'NL',
            ],
            'trademarks'     => [
                [
                    'id'        => 'PAY.',
                    'trademark' => 'TM-1234-1234',
                ],
            ],
            'contactMethods' => [
                [
                    'type'        => 'email',
                    'value'       => 'support@pay.nl',
                    'description' => 'Support desk',
                ],
            ],
            'createdAt'      => DateTime::createFromFormat(DateTime::ATOM, '2007-09-10T13:26:26+02:00'),
            '_links' => [
                [
                    'rel'  => 'self',
                    'type' => 'GET',
                    'url'  => 'https://www.pay.nl/get-merchant'
                ]
            ],
        ], new Merchant());

        $data = $hydrator->extract($merchant);
        $this->assertIsArray($data);
        verify($data)->hasKey('id');
        verify($data)->hasKey('name');
        verify($data)->hasKey('coc');
        verify($data)->hasKey('vat');
        verify($data)->hasKey('website');
        verify($data)->hasKey('bankAccount');
        verify($data)->hasKey('postalAddress');
        verify($data)->hasKey('visitAddress');
        verify($data)->hasKey('trademarks');
        verify($data)->hasKey('contactMethods');
        verify($data)->hasKey('createdAt');
        verify($data)->hasKey('links');

        expect($data['id'])->string();
        expect($data['id'])->equals('M-1000-0001');
        expect($data['name'])->string();
        expect($data['name'])->equals('Pay.nl');
        expect($data['coc'])->string();
        expect($data['coc'])->equals('24283498');
        expect($data['vat'])->string();
        expect($data['vat'])->equals('NL807960147B01');
        expect($data['website'])->string();
        expect($data['website'])->equals('http://www.pay.nl');
        expect($data['bankAccount'])->isInstanceOf(BankAccount::class);
        expect($data['postalAddress'])->isInstanceOf(Address::class);
        expect($data['visitAddress'])->isInstanceOf(Address::class);
        expect($data['trademarks'])->array();
        expect($data['trademarks'])->count(1);
        expect($data['trademarks'])->containsOnlyInstancesOf(Trademark::class);
        expect($data['contactMethods'])->array();
        expect($data['contactMethods'])->count(1);
        expect($data['contactMethods'])->containsOnlyInstancesOf(ContactMethod::class);
        expect($data['createdAt'])->isInstanceOf(DateTime::class);
        expect($data['links'])->isInstanceOf(Links::class);
        expect($data['links'])->count(1);
    }
}

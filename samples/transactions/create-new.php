<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

use PayNL\Sdk\Model\{
    Integration as IntegrationModel,
    Customer as CustomerModel
};

$response = $app
    ->setRequest(
        'CreateTransaction',
        [],
        [
            'Transaction' => [
                'serviceId' => 'SL-3490-4320',
                'description' => 'Test description',
                'merchantReference' => 'Some reference',
                'language' => 'EN',
                'expiresAt' => (new DateTime())->add(new DateInterval('P7D'))->format(DateTime::ATOM),
                'amount' => [
                    'amount'   => 34500,
                    'currency' => 'USD'
                ],
                'paymentMethod' => [
                    'id' => 10,
                    'subId' => 2,
                    'name' => 'Rabobank',
                ],
                'returnUrl' => 'https://www.pay.nl/return-url',
                'exchangeUrl' => 'https://www.pay.nl/exchange-url',
                'transfer' => [
                    'type'=> 'merchant',
                    'value' => 'M-9040-1000',
                    'data' => [
                        'dataaaaa'
                    ],
                ],
                'domainId' => 'WU-5227-3313',
                'integration' => [
                    'testMode' => IntegrationModel::TEST_MODE_ON,
                ],
                'order' => [
                    'countryCode' => 'US',
                    'orderNumber' => 'ORD000000',
                    'deliveryDate' => (new DateTime())->add(new DateInterval('P3D'))->format(DateTime::ATOM),
                    'invoiceDate' => (new DateTime())->format(DateTime::ATOM),
                    'customer' => [
                        'type' => CustomerModel::TYPE_BUSINESS,
                        'name' => 'Bruce',
                        'lastName' => 'Wayne',
                        'ip' => '10.0.0.1',
                        'birthDate' => (new DateTime())->sub(new DateInterval('P24Y'))->format(DateTime::ATOM),
                        'gender' => 'M',
                        'phone' => '612121212',
                        'email' => 'b.wayne@wayne-enterprises.com',
                        'trustLevel' => '-5',
                        'reference' => '123456789',
                        'bankAccount' => [
                            'iban' => 'NL91ABNA0417164300',
                            'bic' => 'INGBNL2A',
                            'owner' => 'Bruce Wayne'
                        ],
                        'company' => [
                            'name' => 'Wayne Enterprises Inc.',
                            'coc' => '12345678',
                            'vat' => '24456789B01',
                            'countryCode' => 'US'
                        ],
                    ],
                    'deliveryAddress' => [
                        'streetName' => 'Mountain Drive',
                        'streetNumber' => '1007',
                        'zipCode' => '24857',
                        'city' => 'Gotham',
                        'regionCode' => 'US-NY',
                        'countryCode' => 'US',
                        'name' => 'B',
                        'lastName' => 'Wayne'
                    ],
                    'invoiceAddress' => [
                        'streetName' => 'Mountain Drive',
                        'streetNumber' => '1007',
                        'zipCode' => '24857',
                        'city' => 'Gotham',
                        'regionCode' => 'US-NY',
                        'countryCode' => 'US',
                        'name' => 'Bruce',
                        'lastName' => 'Wayne'
                    ],
                    'products' => [
                        [
                            'id' => 'P-1000-00021',
                            'description' => 'Tumbler',
                            'price' => [
                                'amount' => '2500000',
                                'currency' => 'USD'
                            ],
                            'quantity' => 1,
                            'vat' => 'N'
                        ],
                    ],
                ],
                'statistics' => [
                    'object' => 'Magento',
                    'info' => 'This is information',
                    'tool' => 'I use this tool',
                    'extra1' => '',
                    'extra2' => 'Something extra',
                    'extra3' => '',
                ],
            ],
        ]
    )->run();

print_response($response);

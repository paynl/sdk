<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

use PayNL\Sdk\Model\Qr;

$requests = [
    'qrUuid' => [
        'serviceId' => $config->get('serviceId'),
        'secret'    => '0123456789abcdef0123456789abcdef01234567',
        'amount'    => [
            'amount'   => 100,
            'currency' => 'EUR',
        ],
        'reference' => 'ABCD0123',
    ],
    'qrIdeal' => [
        'serviceId' => $config->get('serviceId'),
        'secret'    => '0123456789abcdef0123456789abcdef01234567',
        'amount'    => [
            'amount'   => 100,
            'currency' => 'EUR',
        ],
        'reference' => 'ABCD0123',
        'paymentMethod' => [
            'id'   => 10,
            'name' => 'iDeal'
        ],
    ],
    'qrBancontact' => [
        'serviceId' => $config->get('serviceId'),
        'secret'    => '0123456789abcdef0123456789abcdef01234567',
        'amount'    => [
            'amount'   => 100,
            'currency' => 'EUR',
        ],
        'reference' => 'ABCD0123',
        'paymentMethod' => [
            'id'   => 436,
            'name' => 'Mister Cash / Bancontact'
        ],
    ],
];

foreach (['qrUuid', 'qrIdeal', 'qrBancontact'] as $requestType) {
    $response = $app
        ->setRequest(
            'EncodeQr',
            [],
            [
                'Qr' => $requests[$requestType],
            ]
        )
        ->run();

    $qr = $response->getBody();
    if (true === ($qr instanceof Qr)) {
        /** @var Qr $qr */
        if (true === isset($requests[$requestType]['paymentMethod'])) {
            echo "
                <h2>{$requests[$requestType]['paymentMethod']['name']}</h2>
                <table>
                    <tr>
                        <td>QR code from URL</td>
                        <td><img src=\"{$qr->getPaymentLink()}\" title=\"QR code from URL\" /></td>
                    </tr>
                    <tr>
                        <td>QR code from base64 encoded string</td>
                        <td><img src=\"data:image/png;base64,{$qr->getImageContents()}\" title=\"Base64 encoded QR code\" /></td>
                    </tr>
                    <tr>
                        <td>Link to QR code</td>
                        <td><a href=\"{$qr->getExternalPaymentLink()}\">{$qr->getExternalPaymentLink()}</a></td>
                    </tr>
                </table>
            ";
        } else {
            echo '<h2>Get UUID</h2>' . PHP_EOL;
            print_response($response);
        }
    }
}

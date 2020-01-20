<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'RefundTransaction',
        [
            'transactionId' => $config->get('transactionId'),
        ],
        [
            'Refund' => [
                'amount' => [
                    'amount' => 100,
                    'currency' => 'EUR',
                ],
                'bankAccount' => [
                    'iban'  => 'NL91ABNA0417164300',
                    'bic'   => 'INGBNL2A',
                    'owner' => 'Bruce Wayne'
                ],
                'products' => [
                    [
                        'id' => 'P-0000-0000',
                        'description' => 'Test product',
                        'quantity' => 1,
                    ],
                    [
                        'id' => 'P-0000-0001',
                        'description' => 'product as array',
                        'quantity' => 1,
                    ]
                ],
                'reason' => 'Product was broken',
                'processDate' => (new DateTime())->sub(new DateInterval('P2D'))->format(DateTime::ATOM),
            ],
        ]
    )
    ->run()
;

print_response($response);

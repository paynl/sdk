<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'DecodeQr',
        null,
        null,
        [
            'Qr' => [
                'uuid'          => '310021cb-3167-1271-4142-434430313233',
                'secret'        => '0123456789ABCDEF0123456789ABCDEF01234567',
                // members below are optional
                //  'padChar'       => '0',
                //  'referenceType' => 'string',
            ],
        ]
    )
    ->run()
;

print_response($response);

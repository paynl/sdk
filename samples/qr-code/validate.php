<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

use PayNL\Sdk\Response\ResponseInterface;

$response = $app
    ->setRequest(
        'ValidateQr',
        null,
        null,
        [
            'Qr' => [
                'uuid'          => '310021cb-3167-1271-4142-434430313233',
                'secret'        => '0123456789ABCDEF0123456789ABCDEF01234567',
            ],
        ]
    )
    ->run()
;

if (true === in_array($response->getStatusCode(), range(200, 299), true)) {
    $message = ResponseInterface::HTTP_STATUS_CODES[200];
} else {
    $message = ResponseInterface::HTTP_STATUS_CODES[422];
}
echo sprintf(
    "<pre>\n'%s'\n</pre>\n",
    $message
);

<?php

declare(strict_types=1);

$app = require __DIR__ . '/../init_application.php';

$response = $app
    ->setRequest(
        'ValidateQr',
        [],
        [
            'Qr' => [
                'uuid'          => '310021cb-3167-1271-4142-434430313233',
                'secret'        => '0123456789ABCDEF0123456789ABCDEF01234567',
            ],
        ]
    )
    ->run()
;

echo '<pre>';
if (201 === $response->getStatusCode()) {
    echo 'OK';
} else {
    echo 'Not OK';
}
echo '</pre>';

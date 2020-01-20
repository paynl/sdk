<?php

declare(strict_types=1);

require_once __DIR__ . '/../init_application.php';

use PayNL\Sdk\{
    Api,
    Config
};
use PayNL\Sdk\Request\Qr\Encode as EncodeQrRequest;
use PayNL\Sdk\Model\Qr as QrModel;
use PayNL\Sdk\Hydrator\Qr as QrHydrator;

$authAdapter = getAuthAdapter();

$qrUUid = (new QrHydrator())->hydrate([
    'serviceId' => Config::getInstance()->get('serviceId'),
    'secret'    => '0123456789abcdef0123456789abcdef01234567',
    'reference' => 'ABCD0123',
], new QrModel());

$qrIdeal = (new QrHydrator())->hydrate([
    'serviceId' => Config::getInstance()->get('serviceId'),
    'secret'    => '0123456789abcdef0123456789abcdef01234567',
    'reference' => 'ABCD0123',
    'paymentMethod' => [
        'id'   => 10,
        'name' => 'iDeal'
    ]
], new QrModel());

$qrBancontact = (new QrHydrator())->hydrate([
    'serviceId' => Config::getInstance()->get('serviceId'),
    'secret'    => '0123456789abcdef0123456789abcdef01234567',
    'reference' => 'ABCD0123',
    'paymentMethod' => [
        'id'   => 436,
        'name' => 'Mister Cash / Bancontact'
    ]
], new QrModel());

/** @var QrModel $qr */
foreach (compact('qrUUid', 'qrIdeal', 'qrBancontact') as $qr) {
    $request = (new EncodeQrRequest($qr))
        ->setDebug((bool)Config::getInstance()->get('debug'));

    $response = (new Api($authAdapter))
        ->handleCall($request);

    echo '<pre/>' . PHP_EOL .
        var_export($response, true) .
        '<hr/><br/>'
    ;

    if (null !== $qr->getPaymentMethod() && false === empty($response->getBody()->result)) {
        echo "
            <h2>{$qr->getPaymentMethod()->getName()}</h2>
            <div>
                <span>QR code from URL</span>
                <img src=\"{$response->getBody()->result['qrUrl']}\" title=\"QR code from URL\" />
            </div>
            <div>
                <span>QR code from base64 encoded string</span>
                <img src=\"data:image/png;base64,{$response->getBody()->result['qrContents']}\" title=\"Base64 encoded QR code\" />
            </div>
            <div>
                <span>Link to QR code</span>
                <a href=\"{$response->getBody()->result['url']}\">{$response->getBody()->result['url']}</a>
            </div>
        ";
    }
}

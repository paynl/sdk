<?php


require_once '../../vendor/autoload.php';
require_once '../config.php';

const METHOD_IDEAL = 10;

try {
    # Reuired
    $startData['amount'] = 12.5;
    $startData['returnUrl'] = dirname(\Paynl\Helper::getBaseUrl()) . '/finish.php';
    $startData['ipaddress'] = \Paynl\Helper::getIp();

    # Optional
    $startData['exchangeUrl'] = dirname(\Paynl\Helper::getBaseUrl()) . '/exchange.php';
    $startData['paymentMethod'] = METHOD_IDEAL;
    $startData['description'] = 'Order ' . 123456;

    $payResult = \Paynl\Transaction::start($startData);

    # Save this transactionId and link it to your order
    $transactionId = $payResult->getTransactionId();

    # Redirect user to payment page
    header('location: ' . $payResult->getRedirectUrl());
} catch (\Paynl\Error\Error $e) {
    # An error occurred
    echo "Exception: " . $e->getMessage();
}

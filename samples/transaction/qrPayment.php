<?php

require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    $result = \Paynl\Transaction::QRPayment(array(
        'scanData' => '123456789123456789',
        'amount' => 0.01,
        'description' => 'QR payment test',

        'currency' => 'EUR'
    ));
} catch (\Paynl\Error\Error $e) {
    die ('Error: '.$e->getMessage());
}

echo "isPaid: " . ($result->isPaid() ? 'TRUE' : 'FALSE') . "\n";
echo "isCanceled: " . ($result->isCanceled() ? 'TRUE' : 'FALSE') . "\n";
echo "isPending: " . ($result->isPending() ? 'TRUE' : 'FALSE') . "\n";

echo "TransactionId: " . $result->getTransactionId() . "\n";
echo "OrderId: " . $result->getOrderId() . "\n";
echo "StateName: " . $result->getStateName() . "\n";
echo "StateId: " . $result->getStateId() . "\n";
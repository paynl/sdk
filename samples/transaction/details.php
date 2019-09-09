<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

$transactionId = 'EX-1123-3310-3300';
$entranceCode = '';

/** @var \Paynl\Result\Transaction\Transaction $transaction */
try {
    $transaction = \Paynl\Transaction::details(array(
        'transactionId' => $transactionId,
        'entranceCode' => $entranceCode
    ));

    var_dump($transaction->getData());
} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}
<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

$timestamp = '1564652400';

/** @var \Paynl\Result\Transaction\Transaction $transaction */
try {
    $transaction = \Paynl\Transaction::changeStatusList($timestamp);

    var_dump($transaction->getData());
} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}
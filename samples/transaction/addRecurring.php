<?php

require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    $result = \Paynl\Transaction::addRecurring(array(
        'transactionId' => '12345678Xbf1234',
        'amount' => 0.01,
        'description' => 'Your recurring payment',
        'extra1' => 'SDK',
        'extra2' => 'extra2',
        'extra3' => 'extra3'
    ));

    echo $result->getTransactionId();
} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}

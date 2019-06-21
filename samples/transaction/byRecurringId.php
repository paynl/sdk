<?php

require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    $result = \Paynl\Transaction::byRecurringId(array(
        'recurringId' => 'VY-1234-1234-1234',
        'amount' => 0.01,
        'currency' => 'EUR',
        'description' => 'Recurring By Id',
        'cvc' => null,
        'statsData' => array(
            'promotorId' => '1234',
            'info' => '1234 info',
            'tool' => '1234 tool',
            'extra1' => '1234 extra1',
            'extra2' => '1234 extra2',
            'extra3' => '1234 extra3'
        )
    ));

    echo $result->getOrderId(). PHP_EOL;
    echo $result->getEntranceCode(). PHP_EOL;
    echo $result->getOrderAmount(). PHP_EOL;
    echo $result->getOrderDescription(). PHP_EOL;
} catch (\Paynl\Error\Api $e) {
    echo 'The API returned an error: '.$e->getMessage();
} catch (\Paynl\Error\Error $e) {
    echo 'An error occurred: '. $e->getMessage();
}

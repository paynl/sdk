<?php
require_once '../../../vendor/autoload.php';
require_once '../../config.php';
try {
    $result = \Paynl\DirectDebit\Recurring::add(array(
        'amount' => 0.1,
        'bankaccountHolder' => 'N Klant',
        'bankaccountNumber' => 'NL00RABO0123456789',
        'intervalValue' => 1,
        'intervalPeriod' => Paynl\DirectDebit\Recurring::INTERVAL_DAY,
        'intervalQuantity' => 3,
        'bankaccountBic' => 'RABONL2U',
        'processDate' => '08-07-2016',

//         optional
//        'exchangeUrl' => 'http://path_to_your_exchange/file.php',
        'description' => 'De omschrijving',
        'ipAddress' => '192.168.20.123',
        'email' => 'naam@email.com',
        'promotorId' => '123456789',
        'tool' => 'sdk',
        'info' => 'info',
        'object' => 'object',
        'extra1' => 'extra1',
        'extra2' => 'extra2',
        'extra3' => 'extra3',
        'currency' => 'EUR',
    ));
    echo $result->getMandateId();
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

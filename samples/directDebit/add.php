<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';
try {
    $result = \Paynl\DirectDebit::add(array(
        'amount' => 0.1,
        'bankaccountHolder' => 'N. Klant',
        'bankaccountNumber' => 'NL00RAB0123456789',
        
        // optional
        'bankaccountBic' => 'RABONL2U',
//        'exchangeUrl' => 'http://path_to_your_exchange/file.php',
        'processDate' => new \DateTime('tomorrow'),
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

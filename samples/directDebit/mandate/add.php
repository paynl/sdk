<?php
require_once '../../../vendor/autoload.php';
require_once '../../config.php';
try {
    $result = Paynl\DirectDebit\Mandate::add(array(
        'amount' => 0.1,
        'bankaccountHolder' => 'A.M. Pieters',
        'bankaccountNumber' => 'NL91RABO0160099439',

        // optional
        'bankaccountBic' => 'RABONL2U',
        'processDate' => new DateTime('tomorrow'),
        'exchangeUrl' => 'http://requestb.in/th07swth',
        'description' => 'De omschrijving',
        'ipAddress' => '192.168.20.123',
        'email' => 'andy@pay.nl',
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
} catch (\Paynl\Error\Error $e){
    echo "Error: ".$e->getMessage();
}
<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';
try {
    $result = \Paynl\DirectDebit::update(
        // Required
        'IO-1234-1234-1234', // The mandateId of the directdebit.
        // Optional
        array(
        'amount' => 0.1, // The amount to be paid.
        'bankaccountHolder' => 'N. Klant', // The name of the customer.
        'bankaccountNumber' => 'NL00RAB0123456789', // The bankaccount number of the customer.     
        'bankaccountBic' => 'RABONL2U', // The BIC of the bank.
        'processDate' => new \DateTime('tomorrow'), // Date on which the directdebit needs to be processed.
        'intervalValue' =>  1, // Need for recurring part, if intervalValue is 2 and intervalPeriod is 1 than process the directdebit every two weeks.
        'intervalPeriod' => 2, // 1 : Week, 2 : Month, 3: Quarter, 4 : Half year, 5: Year, 6: Day
        'intervalQuantity' => 12, // Indicated the number of times this order should be executed.
        'description' => 'De omschrijving', // First description to include with the payment.
        'ipAddress' => '192.168.20.123', // The IP address of the customer.
        'email' => 'naam@email.com', // The email address of the customer.
        'promotorId' => '123456789', // The ID of the webmaster / promotor.
        'tool' => 'sdk', // The used tool code.
        'info' => 'info', // The used info code.
        'object' => 'object', // The used object.
        'extra1' => 'extra1', // The first free value.
        'extra2' => 'extra2', // The second free value.
        'extra3' => 'extra3', // The third free value.
    
    ));
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

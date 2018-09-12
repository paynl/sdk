<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

/**
 * This example uses the instore paymentMethod with id 1927
 * You have to supply the terminalId in the bank field.
 * The transaction will be sent to the terminal, and the redirectUrl will show a status screen.
 * After the payment is completed, we will redirect the user to the returnUrl
 * All status updates will also be sent to the exchangeUrl
 */
try {
    $result = \Paynl\Transaction::start(array(
        // Required
        'amount' => 12.5,
        'returnUrl' => dirname(\Paynl\Helper::getBaseUrl()) . '/return.php',
        'ipaddress' => \Paynl\Helper::getIp(),
        'paymentMethod' => 1927,
        'bank' => 'TH-9750-0060', // you can supply the terminalId as a bank, you can get all terminals from \Paynl\Instore::getAllTerminals()

        // Optional
        'exchangeUrl' => dirname(\Paynl\Helper::getBaseUrl()) . '/exchange.php',
        'description' => '123456', // the transaction description, usually the orderId
    ));

    // Save this transactionId and link it to your order
    $transactionId = $result->getTransactionId();

    // redirect user to payment page
    header('location: '.$result->getRedirectUrl());
} catch (\Paynl\Error\Error $e) {
    // An error has occurred
    echo "Fout: " . $e->getMessage();
}

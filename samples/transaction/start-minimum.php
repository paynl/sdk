<?php


require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    $result = \Paynl\Transaction::start(array(
        // Required
        'amount' => 12.5,
        'returnUrl' => dirname(\Paynl\Helper::getBaseUrl()) . '/return.php',
        'ipaddress' => \Paynl\Helper::getIp(),

        // Optional
        'exchangeUrl' => dirname(\Paynl\Helper::getBaseUrl()) . '/exchange.php',
        'paymentMethod' => 10,// iDEAL use \Paynl\PaymentMethods::getList() to get all available paymentmethods
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

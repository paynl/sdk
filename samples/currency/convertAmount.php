<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

try
{
    # Amount in cents
    $amount = 100;

    # Target Currency Swedish SEK
    $targetCurrencyId = 16;

    $convertedAmount = \Paynl\Currency::convertAmount($amount, $targetCurrencyId);

    if ($convertedAmount !== false) {
        echo 'Converted amount in cents: ' . $convertedAmount;
    } else {
        echo 'Could not convert amount';
    }

} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}
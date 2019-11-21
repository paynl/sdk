<?php

declare(strict_types=1);

require_once  __DIR__ . '/../vendor/autoload.php';

// vat
$amountIncludingVat = 143.34;
$vatAmount = 23.39;

echo '<pre/>' . PHP_EOL .
    'Amount including VAT: ' . number_format($amountIncludingVat, 2) . PHP_EOL .
    'VAT amount: ' . number_format($vatAmount, 2) . PHP_EOL .
    'VAT percentage: ' . number_format(paynl_calc_vat_percentage($amountIncludingVat, $vatAmount), 2) . PHP_EOL .
    'VAT Class: ' . paynl_determine_vat_class($amountIncludingVat, $vatAmount) . PHP_EOL
;

$address1 = 'Jan Campertlaan 10';
$address2 = 'SomeLane 14b';
$address3 = '124 West Avenue';
echo '<pre/>' . PHP_EOL .
    'Address1: ' . $address1 . PHP_EOL .
    'Address1 split: ' . var_export(paynl_split_address($address1), true) . PHP_EOL .
    PHP_EOL .
    'Address2: ' . $address2 . PHP_EOL .
    'Address2 split: ' . var_export(paynl_split_address($address2), true) . PHP_EOL .
    PHP_EOL .
    'Address3: ' . $address3 . PHP_EOL .
    'Address3 split: ' . var_export(paynl_split_address($address3), true) . PHP_EOL
;

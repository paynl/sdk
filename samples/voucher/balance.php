<?php
/**
 * Get the balance of a voucher
 */
require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    /** @var float $balance */
    $balance = \Paynl\Voucher::balance(array(
        'cardNumber' => '012345678912345678',
        'pincode'    => '1234' // Optional, only needed if the card type needs a pincode
    ));
} catch (\Paynl\Error\Error $e) {
    echo "Error: ". $e->getMessage();
}

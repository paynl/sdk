<?php
/**
 * Subtract an amount from a voucher
 */
require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    /** @var boolean $result */
    $result = \Paynl\Voucher::charge(array(
        'cardNumber' => '012345678912345678',
        'amount'     => 0.5,    // The amount to subtract from the voucher.
        'pincode'    => '0123'  // Optional, only needed if the card type needs a pincode
    ));
} catch (\Paynl\Error\Error $e) {
    echo "Error: " . $e->getMessage();
}

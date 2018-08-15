<?php
/**
 * Activate a new voucher of a given value
 */
require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    /** @var boolean $result */
    $result = \Paynl\Voucher::activate(array(
        'cardNumber' => '012345678912345678',
        'amount'     => 10,         // The amount to put on the voucher
        'posId'      => 'POS-1234', // The ID of the point of sale device.
        'pincode'    => '0123'      // Optional, only needed if the card type needs a pincode
    ));
} catch (\Paynl\Error\Error $e) {
    echo "Error: " . $e->getMessage();
}

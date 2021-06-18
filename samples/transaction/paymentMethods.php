<?php


require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    $paymentMethods = \Paynl\Paymentmethods::getList();
    var_dump($paymentMethods);
} catch (\Paynl\Error\Error $e) {
    echo "ERROR: " . $e->getMessage();
}

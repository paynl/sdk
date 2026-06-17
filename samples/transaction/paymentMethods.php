<?php

define('PROJECT_ROOT', '');

require_once PROJECT_ROOT . '/vendor/autoload.php';
require_once PROJECT_ROOT . '/config.php';

try {
    $paymentMethods = \Paynl\Paymentmethods::getList();
    var_dump($paymentMethods);
} catch (\Paynl\Error\Error $e) {
    echo "ERROR: " . $e->getMessage();
}

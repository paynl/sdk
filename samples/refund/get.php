<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    $refund = \Paynl\Refund::get('RF-1234-5678-1234');
    echo json_encode($refund->getData(), JSON_PRETTY_PRINT);
} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}

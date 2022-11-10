<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';
try {
    $result = \Paynl\DirectDebit::get('IO-1234-1234-1234');
    var_dump($result->getData());
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

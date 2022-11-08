<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';
try {
    $result = \Paynl\DirectDebit::info('IO-9350-3111-3010' /*Required*/, 'IL-1643-7168-1810' /*Optional*/);
    var_dump($result->getData());
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

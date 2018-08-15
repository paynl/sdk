<?php
require_once '../../../vendor/autoload.php';
require_once '../../config.php';
try {
    $result = \Paynl\DirectDebit\Mandate::get('IO-6604-2112-1710');
    $data = $result->getData();
    var_dump($data['result']);
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

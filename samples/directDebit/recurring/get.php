<?php
require_once '../../../vendor/autoload.php';
require_once '../../config.php';
try {
    $result = \Paynl\DirectDebit\Recurring::get('IO-3674-2126-0710');
    $data = $result->getData();
    var_dump($data['result']);
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

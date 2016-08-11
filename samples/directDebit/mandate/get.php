<?php
require_once '../../../vendor/autoload.php';
require_once '../../config.php';
try {
    $result = Paynl\DirectDebit\Mandate::get('IO-6604-2112-1710');
    var_dump($result->getData()['result']);
} catch (\Paynl\Error\Error $e){
    echo "Error: ".$e->getMessage();
}
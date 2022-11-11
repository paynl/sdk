<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';
try {
    $result = \Paynl\DirectDebit::info('IO-1234-1234-1234' /*Required*/, 'IL-1234-1234-1234' /*Optional*/);
    var_dump($result->getData());
} catch (\Paynl\Error\Error $e) {
    echo "Error: " . $e->getMessage();
}

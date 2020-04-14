<?php
require_once 'vendor/autoload.php';
require_once 'config.php';
try {
    $result = \Paynl\DirectDebit::delete(
         // Required
        'IO-1234-1234-1234' // The mandateId of the directdebit.
    );
    var_dump($result);
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

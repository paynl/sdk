<?php
require_once '../../../vendor/autoload.php';
require_once '../../config.php';
try {
    $result = \Paynl\DirectDebit\Mandate::addTransaction(array(
        'mandateId' => 'IO-6604-2112-1710',
        'amount' => 0.10,
        'description' => 'Handmatig herhaald',
        'processDate' => new \DateTime('tomorrow'),
    ));
    var_dump($result->getData());
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

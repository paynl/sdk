<?php

define('PROJECT_ROOT', '');

require_once PROJECT_ROOT . '/vendor/autoload.php';
require_once PROJECT_ROOT . '/config.php';

$transactionId = $_GET['pay_order_id'] ?? ''; // The transactionId you get from transaction/start
$terminalId = $_GET['terminalId'] ?? ''; // the terminalId you get from getAllTerminals

try {
    $result = \Paynl\Instore::payment(array(
        'transactionId' => $transactionId,
        'terminalId' => $terminalId
    ));

    $hash = $result->getHash();

    echo "<a href='getReceipt.php?hash=" . $hash . "'>Receipt</a><br />";
    echo "<a href='confirmPayment.php?hash=" . $hash . "'>Confirm</a><br />";
    echo "<a href='status.php?hash=" . $hash . "'>Status</a><br />";

    echo "<br /><a href='" . $result->getRedirectUrl() . "'>Status - Paynl</a><br />";
} catch (\Paynl\Error\Error $e) {
    echo 'Fout: ' . $e->getMessage();
}

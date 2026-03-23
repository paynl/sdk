<?php

define('PROJECT_ROOT', '');

require_once PROJECT_ROOT . '/vendor/autoload.php';
require_once PROJECT_ROOT . '/config.php';

$hash = $_GET['hash'] ?? ''; //The hash you get from instore/payment

try {
    $result = \Paynl\Instore::status(array('hash' => $hash));

    echo '<pre>';
    print_r($result->getData());
    echo '</pre>';

} catch (\Paynl\Error\Error $e) {
    echo "Fout: " . $e->getMessage();
}

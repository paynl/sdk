<?php

define('PROJECT_ROOT', '');

require_once PROJECT_ROOT . '/vendor/autoload.php';
require_once PROJECT_ROOT . '/config.php';

try {
    $result = \Paynl\Instore::getAllTerminals();

    var_dump($result->getData());
} catch (\Paynl\Error\Error $e) {
    echo "Fout: " . $e->getMessage();
}

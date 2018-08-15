<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

$result = \Paynl\Merchant::deleteTradeName('TM-3311-7380');

var_dump($result);

<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

$result = \Paynl\Merchant::info('M-1234-5678');

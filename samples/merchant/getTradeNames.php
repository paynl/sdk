<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

$tradeNames = \Paynl\Merchant::getTradeNames('M-3421-2120');

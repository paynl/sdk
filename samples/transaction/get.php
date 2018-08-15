<?php
require_once '../../vendor/autoload.php';
require_once '../config.php';

$transactionId = '926417524Xe71be3';

/** @var \Paynl\Result\Transaction\Transaction $transaction */
$transaction = \Paynl\Transaction::get($transactionId);

var_dump($transaction->getData());

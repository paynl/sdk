<?php
include "../gateway.php";

$transaction = $gateway->transactions()->get('EX-3867-3263-7160');

$arrTransaction = $transaction->asArray();


var_dump($arrTransaction);
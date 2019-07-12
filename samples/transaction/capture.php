<?php
include "../gateway.php";

$transaction = $gateway->transactions()->capture('EX-1601-5255-5380');

var_dump($transaction->asJson());
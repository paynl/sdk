<?php
include "../gateway.php";

$transaction = $gateway->transactions()->approve('EX-8401-5255-5380');

var_dump($transaction->status->name);
<?php
include "../gateway.php";

$transaction = $gateway->transactions()->decline('EX-6501-5295-5380');

var_dump($transaction->status->name);
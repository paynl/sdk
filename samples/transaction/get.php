<?php
include "../config.php";

$transaction = $gateway->transaction()->get('EX-1231-3269-6060');

var_dump($transaction);
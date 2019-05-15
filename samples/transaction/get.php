<?php
include "../gateway.php";

$transaction = $gateway->transaction()->get('EX-1957-3226-7160');


var_dump($transaction);


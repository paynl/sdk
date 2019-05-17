<?php
include "../gateway.php";

// TODO This service only had ideal and podiumcadeaukaart, but all payment methods are returned
$paymentMethods = $gateway->services()->getPaymentMethods('SL-7280-6470');

var_dump($paymentMethods);

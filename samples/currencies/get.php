<?php
include "../gateway.php";

$currency = $gateway->currencies()->get('USD');

var_dump($currency);
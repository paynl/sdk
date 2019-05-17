<?php
include "../gateway.php";

$currencies = $gateway->currencies()->getAll();

var_dump($currencies);
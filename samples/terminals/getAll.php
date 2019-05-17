<?php
include "../gateway.php";

$terminals = $gateway->terminals()->getAll();

var_dump($terminals);
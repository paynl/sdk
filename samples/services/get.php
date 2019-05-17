<?php
include "../gateway.php";

$service = $gateway->services()->get('SL-4241-3001');

var_dump($service->_links);

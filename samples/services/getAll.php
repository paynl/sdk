<?php
include "../gateway.php";

$services = $gateway->services()->getAll();

var_dump($services);

foreach ($services as $service){
    echo $service->id.' '.$service->name.PHP_EOL;
}
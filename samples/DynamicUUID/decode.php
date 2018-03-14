<?php
require_once "../../vendor/autoload.php";

$uuid   = 'sl49b880-1234-1234-inv2-018000178532';
$secret = 'abcdef1234567890abcdef1234567890abcdef12';

try {
    $decoded = \Paynl\DynamicUUID::decode($uuid, $secret);
    var_dump($decoded);
} catch (\Paynl\Error\Error $e){
    echo "Error: ".$e->getMessage();
}

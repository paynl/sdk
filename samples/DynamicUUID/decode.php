<?php
require_once "../../vendor/autoload.php";

$uuid   = 'b0898a33-1234-1234-0000-494e56303031';
$secret = 'abcdef1234567890abcdef1234567890abcdef12';

try {
    $decoded = \Paynl\DynamicUUID::decode($uuid, $secret);
    var_dump($decoded);
} catch (\Paynl\Error\Error $e) {
    echo "Error: ".$e->getMessage();
}

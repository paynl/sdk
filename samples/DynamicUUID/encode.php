<?php
require_once "../../vendor/autoload.php";

$UUID = \Paynl\DynamicUUID::encode(
    'SL-1234-1234',
    'abcdef1234567890abcdef1234567890abcdef12',
    'INV001'
);

echo $UUID;

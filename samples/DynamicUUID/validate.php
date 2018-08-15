<?php
require_once "../../vendor/autoload.php";

$uuid = 'sl49b880-1234-1234-inv2-018000178532';
$secret = 'abcdef1234567890abcdef1234567890abcdef12';

$isValid = \Paynl\DynamicUUID::validate($uuid, $secret);

echo $isValid?'The uuid is valid': 'The uuid is NOT valid';

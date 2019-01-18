<?php
require_once "../../vendor/autoload.php";

$UUID = \Paynl\DynamicUUID::encode(
    'SL-1234-1234',
    'abcdef1234567890abcdef1234567890abcdef12',
    'INV001'
);

$ideal = \Paynl\DynamicUUID::ideal($UUID, true);
// load qr image from url
echo "<img src='".$ideal['QRUrl']."'>";
// load qr image from base64
echo "<img src='data:image/png;base64,".$ideal['QRBase64']."'>";
// the url the qr-code points to
echo "<br /><a href='".$ideal['url']."'>".$ideal['url']."</a><br />";


$bancontact = \Paynl\DynamicUUID::bancontact($UUID, true);
// load qr image from url
echo "<img src='".$bancontact['QRUrl']."'>";
// load qr image from base64
echo "<img src='data:image/png;base64,".$bancontact['QRBase64']."'>";
// the url the qr-code points to
echo "<br /><a href='".$bancontact['url']."'>".$bancontact['url']."</a><br />";

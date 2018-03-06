<?php


namespace Paynl;


use Paynl\Error\Error;

class DynamicUUID
{
    public static function encode($serviceId, $secret, $reference, $padChar = '0'){
        self::validateSecret($secret);
        self::validateServiceId($serviceId);
        self::validateReference($reference);
        self::validatePadChar($padChar);

        $UUIDData = preg_replace('/[^0-9]/', '', $serviceId);
        $UUIDData .= str_pad(strtolower($reference), 16, $padChar, STR_PAD_LEFT);

        $hash = hash_hmac('sha256', $UUIDData, $secret);

        $UUID = "sl". substr($hash, 0, 6) . $UUIDData;

        return sprintf('%08s-%04s-%04s-%04s-%12s',
            substr($UUID, 0, 8),
            substr($UUID, 8, 4),
            substr($UUID, 12, 4),
            substr($UUID, 16, 4),
            substr($UUID, 20, 12));
    }

    private static function validateServiceId($strServiceId)
    {
        if(!preg_match('/^SL-[0-9]{4}-[0-9]{4}$/', $strServiceId)) {
            throw new Error('Invalid service ID');
        }
    }
    private static function validateSecret($strSecret)
    {
        if(!preg_match('/^[a-z0-9]+$/i', $strSecret)) {
            throw new Error('Invalid secret');
        }
    }
    private static function validateReference($strReference)
    {
        if(!preg_match('/^[a-z0-9]{0,16}$/i', $strReference)) {
            throw new Error('Invalid reference: only alphanumeric chars are allowed, up to 16 chars long');
        }
    }
    private static function validatePadChar($strPadChar)
    {
        if(!preg_match('/^[a-z0-9]{1}$/i', $strPadChar)) {
            throw new Error('Invalid pad char');
        }
    }
}
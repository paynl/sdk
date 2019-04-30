<?php

namespace Paynl;


use Paynl\Error\Error;

class StaticUUID
{
    const REFERENCE_TYPE_STRING = 1;
    const REFERENCE_TYPE_HEX = 0;
    const HASH_METHOD = 'sha256';

    /**
     * Generate a UUID
     *
     * @param string $serviceId
     * @param string $secret
     * @param string $reference Your reference to the transaction
     * @param double $amount The transaction amount
     * @param string $padChar The reference will be padded with this character, default '0'
     * @param int $referenceType Define if you are using a string (8 chars) of hex (16 chars)
     *
     * @return string The UUID
     */
    public static function encode($serviceId, $secret, $amount, $reference, $padChar = '0', $referenceType=self::REFERENCE_TYPE_STRING)
    {
        if ($referenceType == self::REFERENCE_TYPE_STRING) {
            self::validateReferenceString($reference);
            $reference = self::asciiToHex($reference);
        } else if($referenceType == self::REFERENCE_TYPE_HEX) {
            self::validateReferenceHex($reference);
        }

        self::validateSecret($secret);
        self::validateServiceId($serviceId);
        self::validatePadChar($padChar);

        $amount = round($amount);
        $serviceId = preg_replace('/\D/', '', $serviceId);
        $prefix = strlen($amount);
        $UUIDData = $prefix . $amount . $serviceId;
        $reference = str_pad(strtolower($reference), 16, $padChar, STR_PAD_LEFT);

        $hash = hash_hmac(self::HASH_METHOD, $UUIDData, $secret);

        $UUIDData = str_pad($prefix . $amount, 8, $hash, STR_PAD_RIGHT);
        $UUIDData .= $serviceId . $reference;

        return sprintf('%08s-%04s-%04s-%04s-%12s',
            substr($UUIDData, 0, 8),
            substr($UUIDData, 8, 4),
            substr($UUIDData, 12, 4),
            substr($UUIDData, 16, 4),
            substr($UUIDData, 20, 12));
    }

    private static function asciiToHex($ascii) {
        $hex = '';
        for ($i = 0; $i < strlen($ascii); $i++) {
            $byte = strtoupper(dechex(ord($ascii{$i})));
            $byte = str_repeat('0', 2 - strlen($byte)).$byte;
            $hex.=$byte."";
        }
        return $hex;
    }
    
    private static function validateSecret($strSecret)
    {
        if(preg_match('/^[0-9a-f]{40}$/i', $strSecret) != 1){
            throw new Error("Service secret invalid; service secret should be an alpha numeric string of 40 chars.");
        }
    }

    private static function validateServiceId($strServiceId)
    {
        if ( ! preg_match('/^SL-[0-9]{4}-[0-9]{4}$/', $strServiceId)) {
            throw new Error('Invalid service ID');
        }
    }

    private static function validateReferenceString($strReference)
    {
        if ( ! preg_match('/^[0-9a-zA-Z]{0,8}$/i', $strReference)) {
            throw new Error('Invalid reference: only alphanumeric chars are allowed, up to 8 chars long');
        }
    }

    private static function validateReferenceHex($strReference)
    {
        if ( ! preg_match('/^[0-9a-f]{0,16}$/i', $strReference)) {
            throw new Error('Invalid reference: only alphanumeric chars are allowed, up to 16 chars long');
        }
    }

    private static function validatePadChar($strPadChar)
    {
        if ( ! preg_match('/^[a-z0-9]{1}$/i', $strPadChar)) {
            throw new Error('Invalid pad char');
        }
    }

    /**
     * Decode a UUID
     *
     * @param string $uuid The UUID to decode
     * @param string|null $secret If supplied the uuid will be validated before decoding.
     * @param string $padChar The reference will be padded with this character, default '0'
     *
     * @return array Array with serviceId, reference and amount
     * @throws Error
     */
    public static function decode($uuid, $secret = null, $padChar = '0', $referenceType = self::REFERENCE_TYPE_STRING)
    {
        if ( isset($secret)) {
            self::validateSecret($secret);
            $isValid = self::validate($uuid, $secret);
            if ( ! $isValid) {
                throw new Error('Incorrect signature');
            }
        }

        $uuidData = preg_replace('/[^0-9a-z]/i', '', $uuid);

        $amountLength = substr($uuidData, 0, 1);
        $amount = substr($uuid,1, $amountLength);

        $serviceId = substr($uuidData, 8,8);
        $serviceId = "SL-" . substr($serviceId, 0, 4) . '-' . substr($serviceId, 4, 4);

        $reference = substr($uuidData, 16);

        return array(
            'amount' => $amount,
            'serviceId' => $serviceId,
            'reference' => $reference
        );
    }

    /**
     * Validate a UUID with supplied secret
     *
     * @param string $uuid
     * @param string $secret
     *
     * @return bool
     */
    public static function validate($uuid, $secret)
    {
        $uuidData = preg_replace('/[^0-9a-f]/i', '', $uuid);

        $amountLength = substr($uuidData, 0, 1);
        $amount = substr($uuidData, 1, $amountLength);

        $serviceId = substr($uuidData, 8, 8);
        $strChecksumUUID = substr($uuidData, ($amountLength+1), (7-$amountLength));
        $hash = hash_hmac(self::HASH_METHOD, $amountLength . $amount . $serviceId, $secret);

        return substr($hash, 0, strlen($strChecksumUUID)) == $strChecksumUUID;
    }
}
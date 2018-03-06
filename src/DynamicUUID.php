<?php


namespace Paynl;


use Paynl\Error\Error;

class DynamicUUID
{
    /**
     * Generate a UUID
     *
     * @param string $serviceId
     * @param string $secret
     * @param string $reference Your reference to the transaction
     * @param string $padChar The reference will be padded with this character, default '0'
     *
     * @return string The UUID
     */
    public static function encode($serviceId, $secret, $reference, $padChar = '0')
    {
        self::validateSecret($secret);
        self::validateServiceId($serviceId);
        self::validateReference($reference);
        self::validatePadChar($padChar);

        $UUIDData = preg_replace('/[^0-9]/', '', $serviceId);
        $UUIDData .= str_pad(strtolower($reference), 16, $padChar, STR_PAD_LEFT);

        $hash = hash_hmac('sha256', $UUIDData, $secret);

        $UUID = "sl" . substr($hash, 0, 6) . $UUIDData;

        return sprintf('%08s-%04s-%04s-%04s-%12s',
            substr($UUID, 0, 8),
            substr($UUID, 8, 4),
            substr($UUID, 12, 4),
            substr($UUID, 16, 4),
            substr($UUID, 20, 12));
    }

    private static function validateSecret($strSecret)
    {
        if ( ! preg_match('/^[a-z0-9]+$/i', $strSecret)) {
            throw new Error('Invalid secret');
        }
    }

    private static function validateServiceId($strServiceId)
    {
        if ( ! preg_match('/^SL-[0-9]{4}-[0-9]{4}$/', $strServiceId)) {
            throw new Error('Invalid service ID');
        }
    }

    private static function validateReference($strReference)
    {
        if ( ! preg_match('/^[a-z0-9]{0,16}$/i', $strReference)) {
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
     *
     * @return array Array with serviceId and reference
     * @throws Error
     */
    public static function decode($uuid, $secret = null)
    {
        if ( isset($secret)) {
            self::validateSecret($secret);
            $isValid = self::validate($uuid, $secret);
            if ( ! $isValid) {
                throw new Error('Incorrect signature');
            }
        }

        $uuidData = preg_replace('/[^0-9a-z]/i', '', $uuid);
        $uuidData = substr($uuidData, 8);

        $serviceId = "SL-" . substr($uuidData, 0, 4) . '-' . substr($uuidData, 4, 4);
        $reference = substr($uuidData, 8);

        return array(
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
        $uuidData = preg_replace('/[^0-9a-z]/i', '', $uuid);
        $uuidData = substr($uuidData, 8);

        $hash     = hash_hmac('sha256', $uuidData, $secret);
        $checksum = "sl" . substr($hash, 0, 6);

        return $checksum == substr($uuid, 0, 8);
    }
}
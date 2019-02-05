<?php


namespace Paynl\UUID;

use Paynl\Error\Error;

class DynamicUUID extends UUID
{
    private static $prefix = 'b';
    /**
     * Generate a UUID
     *
     * @param string $serviceId
     * @param string $secret
     * @param string $reference Your reference to the transaction
     * @param string $padChar The reference will be padded with this character, default '0'
     * @param int $referenceType Define if you are using a string (8 chars) of hex (16 chars)
     *
     * @return string The UUID
     */
    public static function encode($serviceId, $secret, $reference, $padChar = '0', $referenceType=self::REFERENCE_TYPE_STRING)
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

        $UUIDData = preg_replace('/\D/', '', $serviceId);
        $UUIDData .= str_pad(strtolower($reference), 16, $padChar, STR_PAD_LEFT);

        $hash = hash_hmac(self::HASH_METHOD, $UUIDData, $secret);

        $UUID = self::$prefix . substr($hash, 0, 7) . $UUIDData;

        return sprintf(
            '%08s-%04s-%04s-%04s-%12s',
            substr($UUID, 0, 8),
            substr($UUID, 8, 4),
            substr($UUID, 12, 4),
            substr($UUID, 16, 4),
            substr($UUID, 20, 12)
        );
    }

    /**
     * Decode a UUID
     *
     * @param string $uuid The UUID to decode
     * @param string|null $secret If supplied the uuid will be validated before decoding.
     * @param string $padChar The reference will be padded with this character, default '0'
     *
     * @return array Array with serviceId and reference
     * @throws Error
     */
    public static function decode($uuid, $secret = null, $padChar = '0', $referenceType = self::REFERENCE_TYPE_STRING)
    {
        if (isset($secret)) {
            self::validateSecret($secret);
            $isValid = self::validate($uuid, $secret);
            if (!$isValid) {
                throw new Error('Incorrect signature');
            }
        }

        $uuidData = preg_replace('/[^0-9a-z]/i', '', $uuid);
        $uuidData = substr($uuidData, 8);

        $serviceId = "SL-" . substr($uuidData, 0, 4) . '-' . substr($uuidData, 4, 4);
        $reference = substr($uuidData, 8);

        $reference = ltrim($reference, $padChar);

        if ($referenceType == self::REFERENCE_TYPE_STRING) {
            $reference = self::hexToString($reference);
        }

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
    public
    static function validate($uuid, $secret)
    {
        $uuidData = preg_replace('/[^0-9a-z]/i', '', $uuid);
        $uuidData = substr($uuidData, 8);

        $hash = hash_hmac(self::HASH_METHOD, $uuidData, $secret);
        $checksum = self::$prefix . substr($hash, 0, 7);

        return $checksum == substr($uuid, 0, 8);
    }
}

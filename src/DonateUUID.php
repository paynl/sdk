<?php


namespace Paynl;


use Paynl\Error\Error;

class DonateUUID extends UUID
{
    private static $prefix = 'd';

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
        $serviceId =  preg_replace('/\D/', '', $serviceId);

        $amountLength = strlen($amount);
        $UUIDData = self::$prefix . $amountLength . $amount . $serviceId;
        $hash = hash_hmac(self::HASH_METHOD, $UUIDData, $secret);

        $reference = str_pad(strtolower($reference), 16, $padChar, STR_PAD_LEFT);
        $UUIDData =   self::$prefix . str_pad($amountLength . $amount, 7, $hash, STR_PAD_RIGHT);

        $UUIDData .= $serviceId . $reference;
        return sprintf('%08s-%04s-%04s-%04s-%12s',
            substr($UUIDData, 0, 8),
            substr($UUIDData, 8, 4),
            substr($UUIDData, 12, 4),
            substr($UUIDData, 16, 4),
            substr($UUIDData, 20, 12));
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

        $amountLength = substr($uuidData, 1, 1);
        $amount = substr($uuidData, 2, $amountLength);

        $serviceId = substr($uuidData, 8,8);
        $serviceId = "SL-" . substr($serviceId, 0, 4) . '-' . substr($serviceId, 4, 4);

        $reference = substr($uuidData, 16);

        if ($referenceType == self::REFERENCE_TYPE_STRING) {
            $reference = self::hexToString($reference);
        }

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

        $amountLength = substr($uuidData, 1, 1);
        $amount = substr($uuidData, 2, $amountLength);
        $serviceId = substr($uuidData, 8, 8);

        $strChecksumUUID = substr($uuidData, ($amountLength+2), (6-$amountLength));
        $hash = hash_hmac('sha256', self::$prefix . $amountLength . $amount . $serviceId, $secret);

        return substr($hash, 0, strlen($strChecksumUUID)) == $strChecksumUUID;
    }
}
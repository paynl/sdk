<?php


namespace Paynl;

use Paynl\Error\Error;

class TransactionUUID extends UUID
{
    private static $prefix = 'a';
    /**
     * Generate a UUID
     *
     * @param string $orderId
     * @param string $entranceCode
     *
     * @return string The UUID
     */
    public static function encode($orderId, $entranceCode)
    {
        self::validateOrderId($orderId);
        self::validateEntranceCode($entranceCode);
        $orderId = str_replace('x', self::$prefix, strtolower($orderId));
        $UUIDBase = substr($entranceCode.$orderId, -29);

        $hash = sha1($UUIDBase);
        $strCheckSum = substr($hash, 11, 2);
        $UUID = self::$prefix . $strCheckSum . $UUIDBase;

        return sprintf(
            '%08s-%04s-%04s-%04s-%12s',
            substr($UUID, 0, 8),
            substr($UUID, 8, 4),
            substr($UUID, 12, 4),
            substr($UUID, 16, 4),
            substr($UUID, 20, 12)
        );
    }

    private static function validateEntranceCode($entranceCode) {
        if (!preg_match('/^[0-9a-z]{40}$/', $entranceCode)) {
            throw new Error('Invalid entrance code');
        }
    }

    private static function validateOrderId($orderId) {
        if (!preg_match('/^[0-9]{10}(X)[0-9a-z]{5}$/', $orderId)) {
            throw new Error('Invalid orderID');
        }
    }

    /**
     * Decode a UUID
     *
     * @param string $uuid The UUID to decode
     *
     * @return array Array with string orderId
     * @throws Error
     */
    public static function decode($uuid)
    {
        $isValid = self::validate($uuid);
        if (!$isValid) {
            throw new Error('Incorrect signature');
        }

        $uuidData = preg_replace('/[^0-9a-z]/i', '', $uuid);
        $orderId =  str_replace('a', 'X', substr($uuidData, -16));
        self::validateOrderId($orderId);
        return array('orderId' => $orderId);
    }

    /**
     * Validate a UUID with supplied secret
     *
     * @param string $uuid
     *
     * @return bool
     */
    public static function validate($uuid)
    {
        $uuidData = preg_replace('/[^0-9a-z]/i', '', $uuid);
        $uuidData = substr($uuidData, 3);

        $hash = sha1($uuidData);
        $checksum = self::$prefix . substr($hash, 11, 2);

        return $checksum == substr($uuid, 0, strlen($checksum));
    }
}

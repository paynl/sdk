<?php


namespace Paynl\UUID;

use Paynl\Error\Error;

class UUID
{
    const REFERENCE_TYPE_STRING = 1;
    const REFERENCE_TYPE_HEX = 0;
    const HASH_METHOD = 'sha256';

    private static $prefix = '';


    protected static function asciiToHex($ascii) {
        $hex = '';
        for ($i = 0; $i < strlen($ascii); $i++) {
            $byte = strtoupper(dechex(ord($ascii{$i})));
            $byte = str_repeat('0', 2 - strlen($byte)).$byte;
            $hex.=$byte."";
        }
        return $hex;
    }

    protected  static function hexToString($hex) {
        return hex2bin($hex);
    }

    protected static function validateSecret($strSecret)
    {
        if (!preg_match('/^[0-9a-f]{40}$/i', $strSecret)) {
            throw new Error('Invalid secret');
        }
    }

    protected static function validateServiceId($strServiceId)
    {
        if (!preg_match('/^SL-[0-9]{4}-[0-9]{4}$/', $strServiceId)) {
            throw new Error('Invalid service ID');
        }
    }

    protected static function validateReferenceString($strReference)
    {
        if (!preg_match('/^[0-9a-zA-Z]{0,8}$/i', $strReference)) {
            throw new Error('Invalid reference: only alphanumeric chars are allowed, up to 8 chars long');
        }
    }

    protected static function validateReferenceHex($strReference)
    {
        if (!preg_match('/^[0-9a-f]{0,16}$/i', $strReference)) {
            throw new Error('Invalid reference: only alphanumeric chars are allowed, up to 16 chars long');
        }
    }

    protected static function validatePadChar($strPadChar)
    {
        if (!preg_match('/^[a-z0-9]{1}$/i', $strPadChar)) {
            throw new Error('Invalid pad char');
        }
    }

    /**
     * Get url and qr-image for bancontact
     * @param $UUID
     * @param $withBase64 True if you need a base64 image
     * @return array url, QRUrl and QRBase64
     */
    public static function bancontact($UUID, $withBase64 = false)
    {
        $qrUrl = 'https://chart.googleapis.com/chart?cht=qr&chs=260x260&chl=https://qr.pisp.me/bc/' . $UUID;
        $result = [
            'url' => 'https://qr.pisp.me/bc/' . $UUID,
            'QRUrl' => $qrUrl
        ];
        if($withBase64) $result['QRBase64'] = base64_encode(file_get_contents($qrUrl));

        return $result;
    }

    /**
     * Get url and qr-image for ideal
     *
     * @param $UUID
     * @param $withBase64 True if you need a base64 image
     * @return array url, QRUrl and QRBase64
     */
    public static function ideal($UUID, $withBase64 = false)
    {
        $qrUrl = 'https://ideal.pay.nl/qr/' . $UUID;
        $result = [
            'url' => 'https://qr6.ideal.nl/' . $UUID,
            'QRUrl' => $qrUrl
        ];

        if($withBase64) $result['QRBase64'] = base64_encode(file_get_contents($qrUrl));

        return $result;
    }
}

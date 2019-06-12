<?php

namespace Paynl;

use Paynl\Error;

/**
 * Description of Helper
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Helper
{

    /**
     * Checks if the apiToken is set
     *
     * @throws Error\Required\ApiToken
     */
    public static function requireApiToken()
    {
        $apiToken = Config::getApiToken();
        if (empty($apiToken)) {
            throw new Error\Required\ApiToken();
        }
    }

    /**
     * Checks if the serviceId is set
     *
     * @throws Error\Required\ServiceId
     */
    public static function requireServiceId()
    {
        $serviceId = Config::getServiceId();
        if (empty($serviceId)) {
            throw new Error\Required\ServiceId();
        }
    }

    /**
     * Get the ip of the user
     *
     * @return string
     */
    public static function getIp()
    {
        // Use $_SERVER or get the headers if we can
        $headers = $_SERVER;
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        }

        // Get the forwarded IP if it exists
        $the_ip = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('X-Forwarded-For', $headers)) {
            $the_ip = $headers['X-Forwarded-For'];
        } elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $headers)) {
            $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
        }
        $arrIp = explode(',', $the_ip);

        return filter_var(trim(trim($arrIp[0]), '[]'), FILTER_VALIDATE_IP);
    }

    /**
     * Redirect the user to a url
     *
     * @param $url
     */
    public static function redirect($url)
    {
        header('location: ' . $url);
    }

    /**
     * Get the nearest number
     *
     * @param int $number
     * @param array $numbers
     * @return int|bool nearest number false on error
     */
    private static function nearest($number, $numbers)
    {
        $output = false;
        $number = (int)$number;
        if (is_array($numbers) && count($numbers) >= 1) {
            $NDat = array();
            foreach ($numbers as $n) {
                $NDat[abs($number - $n)] = $n;
            }
            ksort($NDat);
            $NDat = array_values($NDat);
            $output = $NDat[0];
        }
        return $output;
    }

    /**
     * Convert a stdClass object to an array
     *
     * @param \stdClass $d
     * @return array
     */
    public static function objectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (!is_array($d)) {
            return $d;
        }
        return array_map(array(__CLASS__, __FUNCTION__), $d); // recursive
    }

    /**
     * @param int|float $amountInclTax
     * @param int|float $taxAmount
     * @return float|int
     */
    public static function calculateTaxPercentage($amountInclTax, $taxAmount)
    {
        // return 0 if amount or tax is 0
        if ($taxAmount == 0 || $amountInclTax == 0) {
            return 0;
        }
        $amountExclTax = $amountInclTax - $taxAmount;
        // if $amountInclTax - $taxAmount == 0 the whole amount is tax.
        // That would mean an infinite tax percentage, which is not possible. so in this case we return 100
        if($amountExclTax == 0) return 100;

        return ($taxAmount / $amountExclTax) * 100;
    }

    /**
     * Determine the tax class to send to Pay.nl
     *
     * @param int|float $amountInclTax
     * @param int|float $taxAmount
     * @return string The tax class (N, L or H)
     */
    public static function calculateTaxClass($amountInclTax, $taxAmount)
    {
        $taxClasses = array(
            0 => 'N',
            9 => 'L',
            21 => 'H'
        );

        $taxRate = self::calculateTaxPercentage($amountInclTax, $taxAmount);

        $nearestTaxRate = self::nearest($taxRate, array_keys($taxClasses));
        return $taxClasses[$nearestTaxRate];
    }

    /**
     * Try to split an address into street and housenumber
     * This is not guaranteed to always return a correct answer
     *
     * @param string $strAddress
     * @return array
     */
    public static function splitAddress($strAddress)
    {
        $strAddress = trim($strAddress);

        $a = preg_split(
            '/(\\s+)(\d+)/',
            $strAddress,
            2,
            PREG_SPLIT_DELIM_CAPTURE
        );
        $strStreetName = trim(array_shift($a));
        $strStreetNumber = trim(implode('', $a));

        if (empty($strStreetName) || empty($strStreetNumber)) { // American address notation
            $a = preg_split(
                '/([a-zA-Z]{2,})/',
                $strAddress,
                2,
                PREG_SPLIT_DELIM_CAPTURE
            );

            $strStreetNumber = trim(array_shift($a));
            $strStreetName = implode('', $a);
        }

        return array($strStreetName, substr($strStreetNumber, 0, 45));
    }

    /**
     * Get the url where this script is running.
     * This is used in samples to determine the exchange and return urls
     *
     * @return string
     */
    public static function getBaseUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $url = $protocol . '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];

        // cut at last '/' (we dont want to see index.php)
        return substr($url, 0, strrpos($url, '/'));
    }
}

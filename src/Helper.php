<?php
/*
 * Copyright (C) 2015 Andy Pieters <andy@pay.nl>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Paynl;

use Paynl\Config;
use Paynl\Error;

/**
 * Description of Helper
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Helper
{

    public static function requireApiToken()
    {
        $apiToken = Config::getApiToken();
        if (empty($apiToken)) {
            throw new Error\Required\ApiToken();
        }
    }

    public static function requireServiceId()
    {
        $serviceId = Config::getServiceId();
        if (empty($serviceId)) {
            throw new Error\Required\ServiceId();
        }
    }

    public static function getIp()
    {
        //Just get the headers if we can or else use the SERVER global
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        } else {
            $headers = $_SERVER;
        }
        //Get the forwarded IP if it exists
        if (array_key_exists('X-Forwarded-For', $headers)) {
            $the_ip = $headers['X-Forwarded-For'];
        } elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $headers)) {
            $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
        } else {
            $the_ip = $_SERVER['REMOTE_ADDR'];
        }
        $arrIp  = explode(',', $the_ip);
        $the_ip = $arrIp[0];

        $the_ip = filter_var(trim($the_ip), FILTER_VALIDATE_IP);

        return $the_ip;
    }

    public static function redirect($url)
    {
        header('location: '.$url);
    }


    private static function nearest($number, $numbers)
    {
        $output = FALSE;
        $number = intval($number);
        if (is_array($numbers) && count($numbers) >= 1) {
            $NDat = array();
            foreach ($numbers as $n) {
                $NDat[abs($number - $n)] = $n;
            }
            ksort($NDat);
            $NDat   = array_values($NDat);
            $output = $NDat[0];
        }
        return $output;
    }

    public static function objectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (is_array($d)) {
            return array_map(array(__CLASS__, __FUNCTION__), $d); // recursive
        } else {
            return $d;
        }
    }

    public static function calculateTaxClass($amountInclTax, $taxAmount)
    {
        $taxClasses     = array(
            0 => 'N',
            6 => 'L',
            21 => 'H'
        );
        $amountExclTax  = $amountInclTax - $taxAmount;
        $taxRate        = ($taxAmount / $amountExclTax) * 100;
        $nearestTaxRate = self::nearest($taxRate, array_keys($taxClasses));
        return($taxClasses[$nearestTaxRate]);
    }

    public static function getBaseUrl()
    {
        $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';

        $url = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

        // op de laatste / afknippen (index.php willen we niet zien)
        $baseUrl = substr($url, 0, strrpos($url, '/'));

        return $baseUrl;
    }
}
<?php

namespace Paynl;

use Curl\Curl;

/**
 * Description of Pay
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Config
{

    /**
     * @var string The token code (AT-xxxx-xxxx)
     */
    private static $tokenCode = 'token';

    /**
     * @var string The Pay.nl  API token to be used for requests.
     */
    private static $apiToken;

    /**
     * @var string The service id (SL-xxxx-xxxx)
     */
    private static $serviceId;

    /**
     * @var string The base URL for the Pay.nl API.
     */
    private static $apiBase = 'https://rest-api.pay.nl';

    /**
     * @var int The version of the Pay.nl API to use for requests.
     */
    private static $apiVersion = 5;

    private static $curl;

    /**
     * @var string path tho CAInfo location
     */
    private static $CAInfoLocation;

    /**
     * @var bool Disable this if you have certificate errors that you don't know how to fix
     */
    private static $verifyPeer = true;


    /**
     * @return string
     */
    public static function getTokenCode()
    {
        return self::$tokenCode;
    }

    /**
     * @param string $tokenCode
     */
    public static function setTokenCode($tokenCode)
    {
        self::$tokenCode = $tokenCode;
    }

    /**
     * @return bool
     */
    public static function getVerifyPeer()
    {
        return self::$verifyPeer;
    }

    /**
     * @param bool $verifyPeer
     */
    public static function setVerifyPeer($verifyPeer)
    {
        self::$verifyPeer = (boolean)$verifyPeer;
    }


    /**
     * @param string $apiBase
     */
    public static function setApiBase($apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * @return string
     */
    public static function getCAInfoLocation()
    {
        return self::$CAInfoLocation;
    }

    /**
     * @param string $CAInfoLocation
     */
    public static function setCAInfoLocation($CAInfoLocation)
    {
        self::$CAInfoLocation = $CAInfoLocation;
    }

    /**
     * @return string The API token used for requests.
     */
    public static function getApiToken()
    {
        return self::$apiToken;
    }

    /**
     * Sets the API token to be used for requests.
     *
     * @param string $apiToken
     */
    public static function setApiToken($apiToken)
    {
        self::$apiToken = $apiToken;
    }

    /**
     * @return string The service id used for requests.
     */
    public static function getServiceId()
    {
        return self::$serviceId;
    }

    /**
     * Sets the service id to be used for requests.
     *
     * @param string $serviceId
     */
    public static function setServiceId($serviceId)
    {
        self::$serviceId = $serviceId;
    }

    /**
     * @return string The API version used for requests.
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion The API version to use for requests.
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = (int) $apiVersion;
    }

    /**
     * @param string $endpoint The endpoint of the API, for example Transaction/Start
     * @param int|null $version
     *
     * @return string The url to the api
     */
    public static function getApiUrl($endpoint, $version = null)
    {
        if ($version === null) {
            $version = self::$apiVersion;
        }
        return self::$apiBase . '/v' . $version . '/' . $endpoint . '/json';
    }

    /**
     * @return \Paynl\Curl\CurlInterface
     */
    public static function getCurl()
    {
        if (self::$curl === null) {
            self::$curl = new Curl();
        }

        return self::$curl;
    }

    /**
     * @param mixed $curl
     */
    public static function setCurl($curl)
    {
        if (is_string($curl)) {
            $curl = new $curl;
        }

        self::$curl = $curl;
    }
}

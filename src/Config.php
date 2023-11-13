<?php

namespace Paynl;

use Curl\Curl;

/**
 * Description of Pay
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Config
{
    const CORE1 = 'https://rest-api.pay.nl';
    const CORE1_TEXT = 'Pay.nl (Default)';
    const CORE2 = 'https://rest.achterelkebetaling.nl';
    const CORE2_TEXT = 'Achterelkebetaling.nl';
    const CORE3 = 'https://rest.payments.nl';
    const CORE3_TEXT = 'Payments.nl';

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
     * @var
     */
    private static $ignoreOnPending = true;

    /**
     * @var string The base URL for the Pay.nl API.
     */
    private static $apiBase = 'https://rest-api.pay.nl';

    /**
     * @var string The base URL for the Pay.nl API.
     */
    private static $paymentApiBase = 'https://payment.pay.nl';

    /**
     * @var int The version of the Pay.nl API to use for requests.
     */
    private static $apiVersion = 5;

    /**
     * @var bool Boolean to force using the API version set by this config.
     */
    private static $forceApiVersion = false;

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
     * @return string[]
     */
    public static function getCores()
    {
        return [
          self::CORE1 => self::CORE1_TEXT,
          self::CORE2 => self::CORE2_TEXT,
          self::CORE3 => self::CORE3_TEXT,
        ];
    }

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
     * @param bool $pending
     */
    public static function setIgnoreOnPending($pending)
    {
        self::$ignoreOnPending = (boolean)$pending;
    }

    /**
     * @return bool
     */
    public static function getIgnoreOnPending()
    {
        return self::$ignoreOnPending;
    }

    /**
     * @param string $apiBase
     */
    public static function setApiBase($apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * @param $core
     * @return void
     */
    public static function setCore($core)
    {
        self::setApiBase($core);
    }

    /**
     * @param string $paymentApiBase
     */
    public static function setPaymentApiBase($paymentApiBase)
    {
        self::$paymentApiBase = $paymentApiBase;
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
     * @param bool $forceUse Set to true if you want to force using this version.
     */
    public static function setApiVersion($apiVersion, $forceUse = false)
    {
        self::$apiVersion = (int) $apiVersion;
        self::$forceApiVersion = $forceUse;
    }

    /**
     * @param string $endpoint The endpoint of the API, for example Transaction/Start
     * @param int|null $version
     *
     * @return string The url to the api
     */
    public static function getApiUrl($endpoint, $version = null)
    {
        if ($version === null || self::$forceApiVersion) {
            $version = self::$apiVersion;
        }        
        return self::$apiBase . '/v' . $version . '/' . $endpoint . '/json';
    }

    /**
     * @param string $endpoint The endpoint of the payment API, for example Transaction/Start
     * @param int|null $version
     *
     * @return string The url to the api
     */
    public static function getPaymentApiUrl($endpoint, $version = null)
    {
        if ($version === null || self::$forceApiVersion) {
            $version = self::$apiVersion;
        }

        return self::$paymentApiBase . '/v' . $version . '/' . $endpoint . '/json';
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

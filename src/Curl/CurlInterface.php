<?php
namespace Paynl\Curl;

/**
 * Interface CurlInterface
 * This is the (current) Curl interface as taken from php-curl-class/php-curl-class.
 * This is the interface currently used by the SDK
 *
 * @property string $error
 * @property string $errorMessage
 *
 * @package Paynl\Curl
 */
interface CurlInterface
{
    /**
     * Post
     *
     * @access public
     * @param string $url
     * @param array $data
     * @param bool $follow_303_with_post If true, will cause 303 redirections to be followed using
     *     a POST request (default: false).
     *     Notes:
     *       - Redirections are only followed if the CURLOPT_FOLLOWLOCATION option is set to true.
     *       - According to the HTTP specs (see [1]), a 303 redirection should be followed using
     *         the GET method. 301 and 302 must not.
     *       - In order to force a 303 redirection to be performed using the same method, the
     *         underlying cURL object must be set in a special state (the CURLOPT_CURSTOMREQUEST
     *         option must be set to the method to use after the redirection). Due to a limitation
     *         of the cURL extension of PHP < 5.5.11 ([2], [3]) and of HHVM, it is not possible
     *         to reset this option. Using these PHP engines, it is therefore impossible to
     *         restore this behavior on an existing php-curl-class Curl object.
     *
     * @return mixed
     *
     * [1] https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.3.2
     * [2] https://github.com/php/php-src/pull/531
     * [3] http://php.net/ChangeLog-5.php#5.5.11
     */
    public function post($url, array $data = array(), $follow_303_with_post = false);

    /**
     * Set Opt
     *
     * @access public
     * @param string $option
     * @param mixed $value
     *
     * @return boolean
     */
    public function setOpt($option, $value);
}

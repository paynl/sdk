<?php

namespace Paynl\Api;

use Curl\Curl;
use Paynl\Config;
use Paynl\Error;
use Paynl\Helper;

/**
 * Description of Api
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Api
{
    /**
     * @var int the version of the api
     */
    protected $version = 1;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var bool Is the ApiToken required for this API
     */
    protected $apiTokenRequired = false;
    /**
     * @var bool Is the serviceId required for this API
     */
    protected $serviceIdRequired = false;

    /**
     * @param $endpoint
     * @param null|int $version
     *
     * @return array
     *
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public function doRequest($endpoint, $version = null)
    {
        if ($version === null) {
            $version = $this->version;
        }

        $auth = $this->getAuth();
        $data = $this->getData();
        $uri = Config::getApiUrl($endpoint, (int) $version);

        /** @var Curl $curl */
        $curl = Config::getCurl();

        if (Config::getCAInfoLocation()) {
            // set a custom CAInfo file
            $curl->setOpt(CURLOPT_CAINFO, Config::getCAInfoLocation());
        }

        if (!empty($auth)) {
            $curl->setBasicAuthentication($auth['username'], $auth['password']);
        }


        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, Config::getVerifyPeer());

        $result = $curl->post($uri, $data);

        if (isset($result->status) && $result->status === 'FALSE') {
            throw new Error\Api($result->error);
        }

        if ($curl->error) {
            throw new Error\Error($curl->errorMessage);
        }

        return $this->processResult($result);
    }

    /**
     * @return array
     * @throws Error\Required
     */
    protected function getData()
    {
        if ($this->isServiceIdRequired()) {
            Helper::requireServiceId();

            $this->data['serviceId'] = Config::getServiceId();
        }
        return $this->data;
    }

    /**
     * @return array|null
     * @throws Error\Required\ApiToken
     */
    private function getAuth()
    {
        if (!$this->isApiTokenRequired()) {
            return null;
        }

        Helper::requireApiToken();
        $tokenCode = Config::getTokenCode();
        $apiToken = Config::getApiToken();
        if (!$tokenCode) {
            $this->data['token'] = $apiToken;
            return null;
        }
        return array('username' => $tokenCode, 'password' => $apiToken);
    }

    /**
     * @return bool
     */
    public function isApiTokenRequired()
    {
        return $this->apiTokenRequired;
    }

    /**
     * @return bool
     */
    public function isServiceIdRequired()
    {
        return $this->serviceIdRequired;
    }

    /**
     * @param object|array $result
     *
     * @return array
     * @throws Error\Api
     */
    protected function processResult($result)
    {
        $output = Helper::objectToArray($result);

        if (! is_array($output)) {
            throw new Error\Api($output);
        }

        if (isset($output['result'])) {
            return $output;
        }

        if (
            isset($output['request']) &&
            $output['request']['result'] != 1 &&
            $output['request']['result'] !== 'TRUE') {
            throw new Error\Api($output['request']['errorId'] . ' - ' . $output['request']['errorMessage']);
        }

        return $output;
    }
}

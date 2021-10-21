<?php

namespace Paynl\Api;

use Curl\Curl;
use Paynl\Config;
use Paynl\Error;
use Paynl\Helper;

/**
 * @author Michael Roterman <michael@pay.nl>
 */
class PaymentApi extends Api
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
        $uri = Config::getPaymentApiUrl($endpoint, (int) $version);

        /** @var Curl $curl */
        $curl = Config::getCurl();
        $curl->setHeader('Content-Type', 'application/json');

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
     * @inheritDoc
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
            throw new Error\Api($output['request']['errorMessage']);
        }

        return $output;
    }
}

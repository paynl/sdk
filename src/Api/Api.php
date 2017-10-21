<?php
/*
 * Copyright (C) 2015 Andy Pieters <andy@andypieters.nl>
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

namespace Paynl\Api;

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
    protected $data = [];

    /**
     * @var bool Is the ApiToken required for this API
     */
    protected $apiTokenRequired = false;
    /**
     * @var bool Is the serviceId required for this API
     */
    protected $serviceIdRequired = false;

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
     * @return array
     * @throws Error\Required\ApiToken
     * @throws Error\Required\ServiceId
     */
    protected function getData()
    {
        if($this->isApiTokenRequired()) {
            Helper::requireApiToken();
            $this->data['token'] = Config::getApiToken();
        }
        if($this->isServiceIdRequired()){
            Helper::requireServiceId();
            $this->data['serviceId'] = Config::getServiceId();
        }
        return $this->data;
    }

    /**
     * @param object|array $result
     * @return array
     * @throws Error\Api
     */
    protected function processResult($result)
    {
        $output = Helper::objectToArray($result);

        if(!is_array($output)){
            throw new Error\Api($output);
        }

        if ($output['request']['result'] != 1 && $output['request']['result'] !== 'TRUE') {
            throw new Error\Api($output['request']['errorId'] . ' - ' . $output['request']['errorMessage']);
        }
        return $output;
    }

    /**
     * @param $endpoint
     * @param null|int $version
     * @return array
     *
     * @throws Error\Api
     * @throws Error\Error
     */
    public function doRequest($endpoint, $version = null)
    {
        if($version === null){
            $version = $this->version;
        }

        $data = $this->getData();

        $uri = Config::getApiUrl($endpoint, (int) $version);

        $curl = Config::getCurl();

        if(Config::getCAInfoLocation()){
            // set a custom CAInfo file
            $curl->setOpt(CURLOPT_CAINFO, Config::getCAInfoLocation());
        }

        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, Config::getVerifyPeer());

        $result = $curl->post($uri, $data);

        if($curl->error){
            if(!empty($result)) {
                if ($result->status === 'FALSE') {
                    throw new Error\Api($result->error);
                }
            }
            throw new Error\Error($curl->errorMessage);
        }

        return $this->processResult($result);
    }
}
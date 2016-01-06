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
    protected $data = array();

    /**
     * @var bool Is the ApiToken required for this API
     */
    protected $apiTokenRequired = false;
    /**
     * @var bool Is the serviceId required for this API
     */
    protected $serviceIdRequired = false;

    public function isApiTokenRequired()
    {
        return $this->apiTokenRequired;
    }

    public function isServiceIdRequired()
    {
        return $this->serviceIdRequired;
    }

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

    protected function processResult($result)
    {
        $output = Helper::objectToArray($result);

        if ($output['request']['result'] != 1 && $output['request']['result'] != 'TRUE') {
            throw new Error\Api($output['request']['errorId'] . ' - ' . $output['request']['errorMessage']);
        }
        return $output;
    }

    public function doRequest($endpoint, $version = null)
    {
        $data = $this->getData();

        $uri = Config::getApiUrl($endpoint, $version);

        $curl = new Curl();

        $result = $curl->post($uri, $data);

        $output = static::processResult($result);

        return $output;
    }
}
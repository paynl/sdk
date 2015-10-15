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

use GuzzleHttp\Client;
use Paynl\Config;
use Paynl\Error;
/**
 * Description of Api
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Api {

    protected $data = array();

    protected function getData() {
        if (empty(Config::getApiToken())) {
            throw new Error\Required\ApiToken();
        }
        $this->data['token'] = Config::getApiToken();
        return $this->data;
    }

    public function doRequest($endpoint) {
        $data = $this->getData();

        $uri = Config::getApiUrl($endpoint);
        $client = new Client(['verify'=>false]);

        $response = $client->post($uri, ['form_params' => $data]);
        
        $result = json_decode((string)$response->getBody(), true);
     
        if($result['request']['result'] != 1){
            throw new Error\Api($result['request']['errorId'].' - '.$result['request']['errorMessage']);
        }
        return $result;
    }

}

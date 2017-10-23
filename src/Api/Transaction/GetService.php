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

namespace Paynl\Api\Transaction;

use Paynl\Helper;
use Paynl\Config;

/**
 * Description of GetService
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class GetService extends Transaction
{
    protected $apiTokenRequired = true;
    protected $serviceIdRequired = true;

    /**
     * @var array cached result
     */
    private static $cache = array();

    /**
     * @inheritdoc
     * @throws \Paynl\Error\Required\ServiceId serviceId is required
     */
    protected function getData()
    {
        Helper::requireServiceId();

        $this->data['serviceId'] = Config::getServiceId();

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        if (isset(self::$cache[Config::getServiceId()])) {
            Helper::requireApiToken();
            Helper::requireServiceId();
            return self::$cache[Config::getServiceId()];
        }

        $result = parent::doRequest('transaction/getService');
        self::$cache[Config::getServiceId()] = $result;
        return $result;
    }
}

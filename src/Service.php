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

namespace Paynl;

use Paynl\Api\Service\GetAll;
use Paynl\Api\Service\GetPayLinkUrl;

class Service
{
    /**
     * @param array $options
     * @return mixed
     * @throws \Paynl\Error\Required securityMode is required
     * @throws \Paynl\Error\Required amount is required
     * @throws \Paynl\Error\Required amountMin is required
     */
    public static function getPayLinkUrl(array $options = array())
    {
        if (!isset($options['securityMode'])) {
            throw new Error\Required('securityMode');
        }
        if (!isset($options['amount'])) {
            throw new Error\Required('amount');
        }
        if (!isset($options['amountMin'])) {
            throw new Error\Required('amountMin');
        }

        $api = new GetPayLinkUrl();
        $api->setSecurityMode($options['securityMode']);
        $api->setAmount(round($options['amount']*100));
        $api->setAmountMin(round($options['amountMin']*100));

        if (isset($options['countryCode'])) {
            $api->setCountryCode($options['countryCode']);
        }
        if (isset($options['language'])) {
            $api->setLanguage($options['language']);
        }
        if (isset($options['extra1'])) {
            $api->setExtra1($options['extra1']);
        }
        if (isset($options['extra2'])) {
            $api->setExtra2($options['extra2']);
        }
        if (isset($options['extra3'])) {
            $api->setExtra3($options['extra3']);
        }
        if (isset($options['tool'])) {
            $api->setTool($options['tool']);
        }
        if (isset($options['info'])) {
            $api->setInfo($options['info']);
        }
        $result = $api->doRequest();

        return $result['url'];
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        $api = new GetAll();
        $result = $api->doRequest();
        return $result['services'];
    }
}

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

use Paynl\Api\Transaction as Api;

/**
 * Description of Paymentmethods
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Paymentmethods
{

    /**
     * Reorder the result from the Transaction/getService API into a more logical format
     *
     * @param array $input The result from the getService API
     * @return array
     */
    private static function reorderOutput($input)
    {
        $paymentMethods = array();

        foreach ($input['countryOptionList'] as $country) {
            foreach ($country['paymentOptionList'] as $paymentOption) {
                if (isset($paymentMethods[$paymentOption['id']])) {
                    $paymentMethods[$paymentOption['id']]['countries'][] = $country['id'];
                } else {
                    $banks = array();
                    if (!empty($paymentOption['paymentOptionSubList'])) {
                        foreach ($paymentOption['paymentOptionSubList'] as $optionSub) {
                            $bank = array();
                            $bank['id'] = $optionSub['id'];
                            $bank['name'] = $optionSub['name'];
                            $bank['visibleName'] = $optionSub['visibleName'];
                            $banks[] = $bank;
                        }
                    }

                    $paymentMethod = array(
                        'id' => $paymentOption['id'],
                        'name' => $paymentOption['name'],
                        'visibleName' => $paymentOption['visibleName'],
                        'countries' => array($country['id']),
                        'banks' => $banks,
                    );
                    $paymentMethods[$paymentOption['id']] = $paymentMethod;
                }
            }
        }

        return $paymentMethods;
    }

    /**
     * Filter the result to only return payment methods allowed for a country
     *
     * @param array $paymentMethods
     * @param string $country
     * @return array filtered paymentmethods
     */
    private static function filterCountry($paymentMethods, $country)
    {
        $output = array();
        foreach ($paymentMethods as $paymentMethod) {
            if (in_array($country, $paymentMethod['countries']) || in_array('ALL',
                    $paymentMethod['countries'])
            ) {
                $output[] = $paymentMethod;
            }
        }
        return $output;
    }

    /**
     * Get a list of available payment methods
     *
     * @param array|null $options
     * @return array
     */
    public static function getList($options = array())
    {
        $api = new Api\GetService();
        $result = $api->doRequest();
        $paymentMethods = self::reorderOutput($result);

        if (isset($options['country'])) {
            $paymentMethods = self::filterCountry($paymentMethods,
                $options['country']);
        }

        return $paymentMethods;
    }

    /**
     * Get a list of available banks
     *
     * @param int|null $paymentMethodId If empty, the paymentMethodId for iDEAL will be used
     * @return array
     */
    public static function getBanks($paymentMethodId = 10)
    {
        $paymentMethods = self::getList();
        if (isset($paymentMethods[$paymentMethodId])) {
            return $paymentMethods[$paymentMethodId]['banks'];
        }
        return array();
    }
}

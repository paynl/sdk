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

use Paynl\Api;

/**
 * Description of Paymentmethods
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Paymentmethods
{

    private static function reorderOutput($input)
    {
        $output         = array();
        $paymentMethods = $input['paymentProfiles'];
        foreach ($paymentMethods as $paymentMethod) {
            unset($paymentMethod['visibleName']);
            $paymentMethod['countries'] = array_keys($paymentMethod['countries']);
            $output[]                   = $paymentMethod;
        }
        return $output;
    }

    private static function filterCountry($paymentMethods, $country)
    {
        $output = array();
        foreach ($paymentMethods as $paymentMethod) {
            if (in_array($country, $paymentMethod['countries']) || in_array('ALL',
                    $paymentMethod['countries'])) {
                $output[] = $paymentMethod;
            }
        }
        return $output;
    }

    public static function getList($options = array())
    {
        $api            = new Api\GetService();
        $result         = $api->doRequest();
        $paymentMethods = self::reorderOutput($result);

        if (isset($options['country'])) {
            $paymentMethods = self::filterCountry($paymentMethods,
                    $options['country']);
        }

        return $paymentMethods;
    }

    public static function getBanks($paymentMethodId = 10)
    {
        $api    = new Api\GetService();
        $result = $api->doRequest();
        $banks  = array();
        foreach ($result['countryOptionList'] as $methodsForCountry) {
            if (!empty($methodsForCountry['paymentOptionList'][$paymentMethodId])) {
                foreach ($methodsForCountry['paymentOptionList'][$paymentMethodId]['paymentOptionSubList'] as $bank) {
                    if ($bank['state'] == 1) {
                        $banks[] = [
                            'id' => $bank['id'],
                            'name' => $bank['name'],
                        ];
                    }
                }
                break;
            }
        }
        return $banks;
    }
}
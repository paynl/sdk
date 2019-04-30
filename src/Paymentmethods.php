<?php

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

        $basePath = $input['service']['basePath'];

        foreach ((array)$input['countryOptionList'] as $country) {
            foreach ((array)$country['paymentOptionList'] as $paymentOption) {
                if (isset($paymentMethods[$paymentOption['id']])) {
                    $paymentMethods[$paymentOption['id']]['countries'][] = $country['id'];
                    continue;
                }

                $banks = array();
                if (!empty($paymentOption['paymentOptionSubList'])) {
                    foreach ((array)$paymentOption['paymentOptionSubList'] as $optionSub) {
                        $image = '';
                        if ($paymentOption['id'] == 10) {// only add images for ideal, because the rest will not have images
                            $image = $basePath.$optionSub['path'].$optionSub['img'];
                        }
                        $banks[] = array(
                          'id' => $optionSub['id'],
                          'name' => $optionSub['name'],
                          'visibleName' => $optionSub['visibleName'],
                          'image' => $image,
                        );
                    }
                }
                $paymentMethods[$paymentOption['id']] = array(
                  'id' => $paymentOption['id'],
                  'name' => $paymentOption['name'],
                  'visibleName' => $paymentOption['visibleName'],
                  'countries' => array($country['id']),
                  'banks' => $banks,
                );
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
            if (in_array($country, $paymentMethod['countries'], true)
              || in_array('ALL', $paymentMethod['countries'], true)
            ) {
                $output[] = $paymentMethod;
            }
        }
        return $output;
    }

    /**
     * Get a list of available payment methods
     *
     * @param array $options
     * @return array
     */
    public static function getList(array $options = array())
    {
        $api = new Api\GetService();
        $result = $api->doRequest();
        $paymentMethods = self::reorderOutput($result);

        if (isset($options['country'])) {
            $paymentMethods = self::filterCountry($paymentMethods, $options['country']);
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

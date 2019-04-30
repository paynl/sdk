<?php

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

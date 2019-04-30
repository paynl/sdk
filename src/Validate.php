<?php

namespace Paynl;

use \Paynl\Api\Validate\IsPayServerIp as Api;

/**
 * Description of Paymentmethods
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Validate
{
    public static function isPayServerIp($ipAddress)
    {
        $api = new Api();
        $api->setIpAddress($ipAddress);
        return $api->doRequest();
    }
}

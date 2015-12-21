<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 21-12-2015
 * Time: 12:27
 */

namespace Paynl\Api\Validate;

use \Paynl\Api\Api;
use \Paynl\Error;

class isPayServerIp extends Api
{
    protected function getData()
    {

        if (!isset($this->data['ipAddress'])) {
            throw new Error\Required('ipAddress is required');
        }

        return $this->data;
    }

    public function setIpAddress($ipAddress)
    {
        $this->data['ipAddress'] = $ipAddress;
    }

    protected function processResult($result)
    {
        return (bool)$result->result;
    }

    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('validate/isPayServerIp', 1);
    }
}
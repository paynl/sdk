<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 21-12-2015
 * Time: 12:27
 */

namespace Paynl\Api\Validate;

use \Paynl\Error;

class IsPayServerIp extends Validate
{
    protected $apiTokenRequired = false;
    protected $serviceIdRequired = false;

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
        return parent::doRequest('validate/isPayServerIp');
    }
}
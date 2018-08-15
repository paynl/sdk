<?php

namespace Paynl\Api\Validate;

use \Paynl\Error\Required;

class IsPayServerIp extends Validate
{
    /**
     * @inheritdoc
     * @throws Required ipAddress is required
     */
    protected function getData()
    {
        if (!isset($this->data['ipAddress'])) {
            throw new Required('ipAddress is required');
        }

        return $this->data;
    }

    /**
     * @param $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->data['ipAddress'] = $ipAddress;
    }

    /**
     * @inheritdoc
     * @return bool
     */
    protected function processResult($result)
    {
        return (bool)$result->result;
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('validate/isPayServerIp');
    }
}

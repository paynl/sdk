<?php

namespace Paynl\Api\Voucher;

use Paynl\Api\Api;

class Voucher extends Api
{

    /**
     * @var int the version of the api
     */
    protected $version = 1;

    /**
     * @param string $endpoint
     * @param int|null $version
     *
     * @return array The result
     */
    public function doRequest($endpoint, $version = null)
    {
        if(is_null($version)){
            $version = $this->version;
        }

        return parent::doRequest($endpoint, $version);
    }
}
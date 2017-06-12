<?php
namespace Paynl\Api\Service;

class GetAll extends Service
{
    protected $serviceIdRequired = true;

    /**
     * @param null $endpoint
     * @param null $version
     * @return array
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Service/getAll');
    }
}
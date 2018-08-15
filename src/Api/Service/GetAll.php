<?php
namespace Paynl\Api\Service;

class GetAll extends Service
{
    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Service/getAll');
    }
}

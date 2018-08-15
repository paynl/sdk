<?php

namespace Paynl\Api\Currency;

class GetAll extends Currency
{
    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Currency/getAll', $version);
    }
}

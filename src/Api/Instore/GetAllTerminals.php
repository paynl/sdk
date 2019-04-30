<?php

namespace Paynl\Api\Instore;

/**
 * Description of GetAllTerminals
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class GetAllTerminals extends Instore
{
    protected $apiTokenRequired = true;

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('instore/getAllTerminals');
    }
}

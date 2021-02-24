<?php

namespace Paynl\Api\Creditcard;

use Paynl\Api\Api;

/**
 * Encrypted transaction
 *
 * @author Michael Roterman <michael@pay.nl>
 */
class CseAuthenticate extends AbstractCseRequest
{
    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('creditcard/cseAuthenticate');
    }
}

<?php

namespace Paynl\Api\Creditcard;

use Paynl\Api\Api;

/**
 * Encrypted transaction
 *
 * @author Michael Roterman <michael@pay.nl>
 */
class CseAuthorize extends AbstractCseRequest
{
    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('creditcard/cseAuthorize');
    }
}

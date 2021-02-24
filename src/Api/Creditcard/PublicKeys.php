<?php
namespace Paynl\Api\Creditcard;

use Paynl\Api\Api;

/**
 * Api class to obtain public keys for encryption.
 */
class PublicKeys extends Api
{
    protected $apiTokenRequired = false;

    protected $version = 2;

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('creditcard/cseGetPublicKeys');
    }
}

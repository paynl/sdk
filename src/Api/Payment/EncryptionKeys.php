<?php
namespace Paynl\Api\Payment;

use Paynl\Api\PaymentApi;

/**
 * Api class to obtain public keys for encryption.
 */
class EncryptionKeys extends PaymentApi
{
    /**
     * @inheritdoc
     */
    protected $apiTokenRequired = false;

    /**
     * @inheritdoc
     */
    protected $version = 1;

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Payment/getEncryptionKeys');
    }
}

<?php
namespace Paynl\Api\Payment;

use Paynl\Api\PaymentApi;

/**
 * Api class to obtain public keys for encryption.
 */
class PaymentEncryptionKeys extends PaymentApi
{
    protected $apiTokenRequired = false;

    protected $version = 2;

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Payment/getEncryptionKeys');
    }
}

<?php

namespace Paynl;

use Paynl\Api\Creditcard as Api;
use Paynl\Result\Transaction as Result;

/**
 * Description of Creditcard
 *
 * @author Michael Roterman <michael@pay.nl>
 */
class Creditcard
{
    /**
     * Attempt to capture an encrypted transaction.
     *
     * @param string $transactionId
     * @param string $payload
     *
     * @return array|Result\Details
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function captureWithEncryptedData(
        $transactionId,
        $payload
    )
    {
        $api = new Api\EncryptedTransaction();
        $api->setTransactionId($transactionId);
        $api->setPayload($payload);

        try {
            return $api->doRequest();
        } catch (\Exception $e) {
            return array(
                'type' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            );
        }
    }

    /**
     * Obtain cryptographic keys to use.
     *
     * @return array
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function publicKeys()
    {
        $api = new Api\PublicKeys();

        return $api->doRequest();
    }
}

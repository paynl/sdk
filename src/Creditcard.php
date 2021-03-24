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
     * Attempt to authorize a encrypted transaction.
     *
     * @param string $orderId
     *
     * @param string $payload
     *
     * @return array|Result\Details
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function cseAuthorize(
        $orderId,
        $threeDSTransactionId,
        $payload
    ) {
        $api = new Api\CseAuthorize();

        $api->setOrderId($orderId);
        $api->setThreeDSTransactionId($threeDSTransactionId);
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
     * Attempt to authenticate a encrypted transaction.
     *
     * @param string $orderId
     * @param string $payload
     * @param string|null $threeDSTransactionId
     *
     * @return array|Result\Details
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function cseAuthenticate(
        $orderId,
        $payload,
        $threeDSTransactionId = null
    ) {
        $api = new Api\CseAuthenticate();
        
        $api->setOrderId($orderId);
        $api->setPayload($payload);
        $api->setThreeDSTransactionId($threeDSTransactionId);

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
     * Attempt to authenticate a encrypted transaction.
     *
     * @param string $transactionId
     *
     * @return array|Result\Details
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function cseTdsStatus(
        $transactionId
    ) {
        $api = new Api\CseTdsStatus();
        $api->setTransactionId($transactionId);

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

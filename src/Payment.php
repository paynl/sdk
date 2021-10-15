<?php

namespace Paynl;

use Paynl\Api\Payment as Api;
use Paynl\Result\Transaction as Result;

/**
 * @author Michael Roterman <michael@pay.nl>
 */
class Payment
{
    /**
     * Attempt to authorize a encrypted transaction.
     *
     * @param string $orderId
     * @param string $entranceCode
     * @param string $threeDSTransactionId
     * @param string $acquirerId
     * @param string $payload
     *
     * @return array|Result\Details
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function paymentAuthorize(
        $orderId,
        $entranceCode,
        $threeDSTransactionId,
        $acquirerId,
        $payload
    ) {
        $api = new Api\PaymentAuthorize();

        $api->setOrderId($orderId);
        $api->setEntranceCode($entranceCode);
        $api->setThreeDSTransactionId($threeDSTransactionId);
        $api->setAcquirerId($acquirerId);
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
     * @param array $options
     *
     * @return array|Result\Details
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function paymentAuthenticate(
        array $options = array()
    ) {
        $api = new Api\PaymentAuthenticate();

        if (!empty($options['transactionId'])) {
            $api->setOrderId($options['transactionId']);
            $api->setEntranceCode($options['entranceCode']);
        } else {
            $api->setAmount(round($options['amount'] * 100));
            $api->setCurrency($options['currency']);
            $api->setFinishUrl($options['returnUrl']);
            $api->setDescription($options['description']);
        }

        if (!empty($options['identifier'])) {
            $api->setKeyIdentifier($options['identifier']);
        }

        if (!empty($options['data'])) {
            $api->setCardData($options['data']);
        }

        if (!empty($options['threeDSTransactionId'])) {
            $api->setThreeDSTransactionId($options['threeDSTransactionId']);
        }

        if (!empty($options['acquirer_id'])) {
            $api->setAcquirerId($options['acquirer_id']);
        }

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
     * Get the authentication status of a payment.
     *
     * @param string $transactionId
     *
     * @return array|Result\Details
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function paymentAuthenticationStatus(
        $transactionId
    ) {
        $api = new Api\PaymentAuthenticationStatus();
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
    public static function paymentEncryptionKeys()
    {
        $api = new Api\PaymentEncryptionKeys();

        return $api->doRequest();
    }
}

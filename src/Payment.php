<?php

namespace Paynl;

use Paynl\Api;
use Paynl\Api\Payment\Model;
use Paynl\Result;

class Payment
{
    /**
     * @param Model\Authorize\Transaction $transaction
     * @param Model\Payment $payment
     * @return Result\Payment\Authorize
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function authorize(
        Model\Authorize\Transaction $transaction,
        Model\Payment $payment
    ) {
        $authorize = new Model\Authorize();
        $authorize
            ->setTransaction($transaction)
            ->setPayment($payment);

        $api = new Api\Payment\Authorize($authorize);
        return new Result\Payment\Authorize($api->doRequest());
    }

    /**
     * Attempt to authenticate an encrypted transaction.
     *
     * @param Model\Authenticate\Transaction $transaction
     * @param Model\Customer $customer
     * @param Model\CSE $cse
     * @param Model\Browser $browser
     * @return Result\Payment\Authenticate
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function authenticate(
        Model\Authenticate\Transaction $transaction,
        Model\Customer $customer,
        Model\CSE $cse,
        Model\Browser $browser
    ) {
        $authenticate = new Model\Authenticate();

        $payment = new Model\Payment();
        $payment
            ->setMethod(Model\Payment::METHOD_CSE)
            ->setCse($cse)
            ->setBrowser($browser);

        $authenticate
            ->setTransaction($transaction)
            ->setOptions(array())
            ->setCustomer($customer)
            ->setOrder(array())
            ->setStats(array())
            ->setPayment($payment);

        $api = new Api\Payment\Authenticate($authenticate);
        return new Result\Payment\Authenticate($api->doRequest());
    }

    /**
     * @param Model\AbstractTransaction $transaction
     * @param Model\Payment $payment
     * @return Result\Payment\AuthenticateMethod
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function authenticateMethod(
        Model\AbstractTransaction $transaction,
        Model\Payment $payment
    ) {
        $authenticateMethod = new Model\AuthenticateMethod();
        $authenticateMethod
            ->setTransaction($transaction)
            ->setPayment($payment);

        $api = new Api\Payment\AuthenticateMethod($authenticateMethod);
        return new Result\Payment\AuthenticateMethod($api->doRequest());
    }

    /**
     * Get the authentication status of a payment.
     *
     * @param string $transactionId
     *
     * @return Result\Payment\AuthenticationStatus
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function authenticationStatus(
        $transactionId
    ) {
        $api = new Api\Payment\AuthenticationStatus($transactionId);
        return new Result\Payment\AuthenticationStatus($api->doRequest());
    }

    /**
     * Obtain cryptographic keys to use.
     *
     * @return Result\Payment\EncryptionKeys
     * @throws Error\Api
     * @throws Error\Error
     * @throws Error\Required\ApiToken
     */
    public static function paymentEncryptionKeys()
    {
        $api = new Api\Payment\EncryptionKeys();
        return new Result\Payment\EncryptionKeys($api->doRequest());
    }
}

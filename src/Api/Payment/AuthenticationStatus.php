<?php

namespace Paynl\Api\Payment;

use Paynl\Api\PaymentApi;

class AuthenticationStatus extends PaymentApi
{
    /**
     * @var string
     */
    private $transactionId;

    protected $apiTokenRequired = true;

    /**
     * @param string $transactionId
     */
    public function __construct($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest("Payment/getAuthenticationStatus", 1);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            'transactionId' => $this->transactionId
        );
    }
}
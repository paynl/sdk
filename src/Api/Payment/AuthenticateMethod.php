<?php

namespace Paynl\Api\Payment;

use Paynl\Api\PaymentApi;

class AuthenticateMethod extends PaymentApi
{
    /**
     * @var Model\AuthenticateMethod
     */
    private $authenticateMethod;

    protected $apiTokenRequired = true;

    /**
     * @param Model\AuthenticateMethod $authenticateMethod
     */
    public function __construct(Model\AuthenticateMethod $authenticateMethod)
    {
        $this->authenticateMethod = $authenticateMethod;
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest("Payment/authenticate", 1);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->authenticateMethod->toArray();
    }
}
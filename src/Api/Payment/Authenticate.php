<?php

namespace Paynl\Api\Payment;

use Paynl\Api\Payment\Model;
use Paynl\Api\PaymentApi;

class Authenticate extends PaymentApi
{
    /**
     * @var Model\Authenticate
     */
    private $authenticate;

    protected $apiTokenRequired = true;

    /**
     * @param Model\Authenticate $authenticate
     */
    public function __construct(Model\Authenticate $authenticate)
    {
        $this->authenticate = $authenticate;
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
        return $this->authenticate->toArray();
    }
}

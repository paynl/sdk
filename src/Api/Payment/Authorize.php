<?php

namespace Paynl\Api\Payment;

use Paynl\Api\PaymentApi;
use Paynl\Error;

class Authorize extends PaymentApi
{
    /**
     * @var Model\Authorize
     */
    private $authorize;

    /**
     * @inheritdoc
     */
    protected $apiTokenRequired = true;

    /**
     * @param Model\Authorize $authorize
     */
    public function __construct(Model\Authorize $authorize)
    {
        $this->authorize = $authorize;
    }

    /**
     * @param $endpoint
     * @param null $version
     * @return array
     * @throws Error\Required\ApiToken
     * @throws Error\Api
     * @throws Error\Error
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Payment/authorize', 1);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->authorize->toArray();
    }
}

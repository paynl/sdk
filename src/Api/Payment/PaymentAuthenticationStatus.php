<?php

namespace Paynl\Api\Creditcard;

use Paynl\Api\PaymentApi;

/**
 * @author Michael Roterman <michael@pay.nl>
 */
class PaymentAuthenticationStatus extends PaymentApi
{
    /**
     * @var int the version of the api
     */
    protected $version = 2;

    /**
     * @var string
     */
    private $transactionId;
    
    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('Payment/getAuthenticationStatus');
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return array_merge(parent::getData(), array(
            'transactionId' => $this->transactionId
        ));
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }
}

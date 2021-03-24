<?php

namespace Paynl\Api\Creditcard;

use Paynl\Api\Api;

/**
 * Encrypted transaction
 *
 * @author Michael Roterman <michael@pay.nl>
 */
abstract class AbstractCseRequest extends Api
{
    private $orderId;
    private $payload;
    private $threeDSTransactionId;

    /**
     * @var int the version of the api
     */
    protected $version = 2;
    
    /**
     * @var bool Is the ApiToken required for this API
     */
    protected $apiTokenRequired = true;

    public function getData()
    {
        return array_merge(parent::getData(), array(
            'orderId' => $this->getOrderId(),
            'threeDSTransactionId' => $this->getThreeDSTransactionId(),
            'payload' => $this->getPayload()
        ));
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return string|null
     */
    public function getThreeDSTransactionId()
    {
        return $this->threeDSTransactionId;
    }

    /**
     * @param string|null $threeDSTransactionId
     */
    public function setThreeDSTransactionId($threeDSTransactionId)
    {
        $this->threeDSTransactionId = $threeDSTransactionId;
    }
}

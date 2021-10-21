<?php

namespace Paynl\Api\Payment\Model\Authenticate;

use Paynl\Api\Payment\Model\AbstractTransaction;

class TransactionMethod extends AbstractTransaction
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var string
     */
    private $entranceCode;

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     * @return static
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntranceCode()
    {
        return $this->entranceCode;
    }

    /**
     * @param string $entranceCode
     * @return static
     */
    public function setEntranceCode($entranceCode)
    {
        $this->entranceCode = $entranceCode;
        return $this;
    }
}
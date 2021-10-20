<?php

namespace Paynl\Api\Payment\Model;

class Auth extends Model
{
    /**
     * @var string
     */
    private $payTdsTransactionId;

    /**
     * @var string
     */
    private $payTdsAcquirerId;

    /**
     * @return string
     */
    public function getPayTdsTransactionId()
    {
        return $this->payTdsTransactionId;
    }

    /**
     * @param string $payTdsTransactionId
     * @return static
     */
    public function setPayTdsTransactionId($payTdsTransactionId)
    {
        $this->payTdsTransactionId = $payTdsTransactionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayTdsAcquirerId()
    {
        return $this->payTdsAcquirerId;
    }

    /**
     * @param string $payTdsAcquirerId
     * @return static
     */
    public function setPayTdsAcquirerId($payTdsAcquirerId)
    {
        $this->payTdsAcquirerId = $payTdsAcquirerId;
        return $this;
    }
}
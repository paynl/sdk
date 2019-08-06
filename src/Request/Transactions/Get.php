<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Get extends AbstractRequest
{
    /**
     * @var string
     */
    protected $transactionId;

    public function __construct(string $transactionId)
    {
        $this->setTransactionId($transactionId);
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     *
     * @return Get
     */
    public function setTransactionId(string $transactionId): Get
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    public function getUri(): string
    {
        return 'transactions/' . $this->getTransactionId();
    }
}

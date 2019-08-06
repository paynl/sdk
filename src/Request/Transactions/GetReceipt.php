<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class GetReceipt extends AbstractRequest
{
    /**
     * @var string
     */
    protected $transactionId;

    /**
     * GetReceipt constructor.
     *
     * @param string $transactionId
     */
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
     * @return GetReceipt
     */
    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'transactions/' . $this->getTransactionId() . '/receipt';
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Refunds;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Refund as RefundTransformer
};

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Refunds
 */
class Get extends AbstractRequest
{
    /**
     * @var string
     */
    protected $refundId;

    /**
     * Get constructor.
     *
     * @param string $refundId
     */
    public function __construct(string $refundId)
    {
        $this->setRefundId($refundId);
    }

    /**
     * @return string
     */
    public function getRefundId(): string
    {
        return $this->refundId;
    }

    /**
     * @param string $refundId
     *
     * @return Get
     */
    public function setRefundId(string $refundId): Get
    {
        $this->refundId = $refundId;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "refunds/{$this->getRefundId()}";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @return RefundTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new RefundTransformer();
    }
}

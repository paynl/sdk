<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Refunds;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest
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
     * @inheritDoc
     */
    public function init(): void
    {
        $refundId = (string)$this->getParam('refundId');
        if (null === $refundId) {
            throw new MissingParamException('Missing param!');
        }
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
}

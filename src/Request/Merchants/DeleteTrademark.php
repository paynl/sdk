<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Merchants;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\MerchantIdTrait;

/**
 * Class DeleteTrademark
 *
 * @package PayNL\Sdk\Request\Merchants
 */
class DeleteTrademark extends AbstractRequest
{
    use MerchantIdTrait;

    /**
     * @var string
     */
    protected $trademarkId;

    /**
     * DeleteTrademark constructor.
     *
     * @param string $merchantId
     * @param string $trademarkId
     */
    public function __construct(string $merchantId, string $trademarkId)
    {
        $this->setMerchantId($merchantId);
        $this->setTrademarkId($trademarkId);
    }

    /**
     * @return string
     */
    public function getTrademarkId(): string
    {
        return $this->trademarkId;
    }

    /**
     * @param string $trademarkId
     *
     * @return DeleteTrademark
     */
    protected function setTrademarkId(string $trademarkId): DeleteTrademark
    {
        $this->trademarkId = $trademarkId;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "merchants/{$this->getMerchantId()}/trademarks/{$this->getTrademarkId()}";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_DELETE;
    }
}

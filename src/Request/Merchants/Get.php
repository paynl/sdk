<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Merchants;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Merchant as MerchantTransformer
};
use PayNL\Sdk\Request\Parameter\MerchantIdTrait;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Merchants
 */
class Get extends AbstractRequest
{
    use MerchantIdTrait;

    /**
     * Get constructor.
     *
     * @param string $merchantId
     */
    public function __construct(string $merchantId)
    {
        $this->setMerchantId($merchantId);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "merchants/{$this->getMerchantId()}";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @return MerchantTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new MerchantTransformer();
    }
}

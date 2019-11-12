<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Merchants;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Model\Trademark,
    Transformer\TransformerInterface,
    Transformer\Merchant as MerchantTransformer
};
use PayNL\Sdk\Request\Parameter\MerchantIdTrait;

/**
 * Class AddTrademark
 *
 * @package PayNL\Sdk\Request\Merchants
 */
class AddTrademark extends AbstractRequest
{
    use MerchantIdTrait;

    /**
     * AddTrademark constructor.
     *
     * @param string $merchantId
     * @param Trademark $trademark
     */
    public function __construct(string $merchantId, Trademark $trademark)
    {
        $this->setMerchantId($merchantId);
        $this->setBody($trademark);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "merchants/{$this->getMerchantId()}/trademarks";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }

    /**
     * @return MerchantTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new MerchantTransformer();
    }
}

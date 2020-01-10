<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Merchants;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest,
    Request\Parameter\MerchantIdTrait,
    Model\Trademark,
    Transformer\TransformerInterface,
    Transformer\Merchant as MerchantTransformer
};

/**
 * Class AddTrademark
 *
 * @package PayNL\Sdk\Request\Merchants
 */
class AddTrademark extends AbstractRequest
{
    use MerchantIdTrait;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $merchantId = (string)$this->getParam('merchantId');
        if (true === empty($merchantId)) {
            throw new MissingParamException(
                'missing merchant Id'
            );
        }

        $this->setMerchantId($merchantId);
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
}

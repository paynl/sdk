<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Merchants;

use PayNL\Sdk\{Exception\MissingParamException,
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Merchant as MerchantTransformer};
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
     * @inheritDoc
     */
    public function init():void
    {
        $merchantId = (string)$this->getParam('merchantId');
        if (true === empty($merchantId)) {
            throw new MissingParamException(
                'Missing merchant id'
            );
        }
        $this->setMerchantId($merchantId);

        $trademarkId = (string)$this->getParam('trademarkId');
        if (true === empty($trademarkId)) {
            throw new MissingParamException(
                'Missing trademark id'
            );
        }
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

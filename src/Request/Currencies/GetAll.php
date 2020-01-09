<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Currencies;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Collection as CollectionTransformer
};

/**
 * Class Currencies
 *
 * @package PayNL\Sdk\Request\Currencies
 */
class GetAll extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'currencies';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @return CollectionTransformer
     */
//    public function getTransformer(): TransformerInterface
//    {
//        return new CollectionTransformer('currencies');
//    }
}

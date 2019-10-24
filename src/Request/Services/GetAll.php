<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Services;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Services as ServicesTransformer
};

/**
 * Class GetAll
 *
 * @package PayNL\Sdk\Request\Services
 */
class GetAll extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'services';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @return ServicesTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new ServicesTransformer();
    }
}

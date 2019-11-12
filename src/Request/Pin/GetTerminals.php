<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Terminals as TerminalsTransformer
};

/**
 * Class GetTerminals
 *
 * @package PayNL\Sdk\Request\Pin
 */
class GetTerminals extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'pin/terminals';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @return TerminalsTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new TerminalsTransformer();
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Terminals;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Terminals
 */
class Get extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'terminals';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }
}

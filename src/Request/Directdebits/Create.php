<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Directdebits;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Create
 *
 * @package PayNL\Sdk\Request\Directdebits
 */
class Create extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'directdebits';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }
}

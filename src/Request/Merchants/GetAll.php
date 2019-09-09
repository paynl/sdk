<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Merchants;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class GetAll
 *
 * @package PayNL\Sdk\Request\Merchants
 */
class GetAll extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'merchants';
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }
}

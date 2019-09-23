<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Directdebits;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\IncassoOrderIdTrait;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Directdebits
 */
class Get extends AbstractRequest
{
    use IncassoOrderIdTrait;

    /**
     * Get constructor.
     *
     * @param string $incassoOrderId
     */
    public function __construct(string $incassoOrderId)
    {
        $this->setIncassoOrderId($incassoOrderId);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "directdebits/{$this->getIncassoOrderId()}";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }
}

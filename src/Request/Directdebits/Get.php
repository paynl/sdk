<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Directdebits;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest,
    Request\Parameter\IncassoOrderIdTrait
};

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\Directdebits
 */
class Get extends AbstractRequest
{
    use IncassoOrderIdTrait;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $incassoOrderId = (string)$this->getParam('incassoOrderId');
        if (null === $incassoOrderId) {
            throw new MissingParamException('Missing param!');
        }
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

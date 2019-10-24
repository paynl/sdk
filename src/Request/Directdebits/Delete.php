<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Directdebits;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\NoContent as NoContentTransformer
};
use PayNL\Sdk\Request\Parameter\IncassoOrderIdTrait;

/**
 * Class Delete
 *
 * @package PayNL\Sdk\Request\Directdebits
 */
class Delete extends AbstractRequest
{
    use IncassoOrderIdTrait;

    /**
     * Delete constructor.
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
        return static::METHOD_DELETE;
    }

    /**
     * @return NoContentTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new NoContentTransformer();
    }
}

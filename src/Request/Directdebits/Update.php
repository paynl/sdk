<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Directdebits;

use PayNL\Sdk\{
    Model\Mandate,
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Directdebit as DirectdebitTransformer
};
use PayNL\Sdk\Request\Parameter\IncassoOrderIdTrait;

/**
 * Class Update
 *
 * @package PayNL\Sdk\Request\Directdebits
 */
class Update extends AbstractRequest
{
    use IncassoOrderIdTrait;

    /**
     * Update constructor.
     *
     * @param string $incassoOrderId
     * @param Mandate $mandate
     */
    public function __construct(string $incassoOrderId, Mandate $mandate)
    {
        $this->setIncassoOrderId($incassoOrderId);
        $this->setBody($mandate);
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
        return static::METHOD_PATCH;
    }

    /**
     * @return DirectdebitTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new DirectdebitTransformer();
    }
}

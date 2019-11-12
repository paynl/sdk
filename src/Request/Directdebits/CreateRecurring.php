<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Directdebits;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Model\Mandate,
    Transformer\TransformerInterface,
    Transformer\Directdebit as DirectdebitTransformer
};
use PayNL\Sdk\Request\Parameter\IncassoOrderIdTrait;

/**
 * Class CreateRecurring
 *
 * @package PayNL\Sdk\Request\Directdebits
 */
class CreateRecurring extends AbstractRequest
{
    use IncassoOrderIdTrait;

    /**
     * CreateRecurring constructor.
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
        return "directdebits/{$this->getIncassoOrderId()}/debits";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }

    /**
     * @return DirectdebitTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new DirectdebitTransformer();
    }
}

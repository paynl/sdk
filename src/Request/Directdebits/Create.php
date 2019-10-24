<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Directdebits;

use PayNL\Sdk\{
    Model\Mandate,
    Request\AbstractRequest,
    Transformer\Directdebit as DirectdebitTransformer,
    Transformer\TransformerInterface
};

/**
 * Class Create
 *
 * @package PayNL\Sdk\Request\Directdebits
 */
class Create extends AbstractRequest
{
    /**
     * Create constructor.
     *
     * @param Mandate $mandate
     */
    public function __construct(Mandate $mandate)
    {
        $this->setBody($mandate);
    }

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

    /**
     * @return DirectdebitTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new DirectdebitTransformer();
    }
}

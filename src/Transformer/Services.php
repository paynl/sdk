<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Hydrator\Services as ServicesHydrator,
    Model\Services as ServicesModel
};

/**
 * Class Services
 *
 * @package PayNL\Sdk\Transformer
 */
class Services extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return (new ServicesHydrator)->hydrate($inputToTransform, new ServicesModel());
    }
}

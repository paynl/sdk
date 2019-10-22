<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Hydrator\Service as ServiceHydrator,
    Model\Service as ServiceModel
};

/**
 * Class Service
 *
 * @package PayNL\Sdk\Transformer
 */
class Service extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @return ServiceModel
     */
    public function transform($inputToTransform): ServiceModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return (new ServiceHydrator())->hydrate($inputToTransform, new ServiceModel());
    }
}

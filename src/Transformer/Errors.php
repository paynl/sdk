<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Model\Errors as ErrorsModel,
    Hydrator\Errors as ErrorsHydrator
};

/**
 * Class Errors
 *
 * @package PayNL\Sdk\Transformer
 */
class Errors extends AbstractTransformer
{
    /**
     * @inheritDoc
     *
     * @return ErrorsModel
     */
    public function transform($inputToTransform): ErrorsModel
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return (new ErrorsHydrator())->hydrate($inputToTransform, new ErrorsModel());
    }
}

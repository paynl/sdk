<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Model\PaymentMethods as PaymentMethodsModel,
    Hydrator\PaymentMethods as PaymentMethodsHydrator
};

/**
 * Class PaymentMethod
 *
 * @package PayNL\Sdk\Transformer
 */
class _PaymentMethods extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        return (new PaymentMethodsHydrator())->hydrate($inputToTransform, new PaymentMethodsModel());
    }
}

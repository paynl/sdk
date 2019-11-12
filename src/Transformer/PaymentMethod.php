<?php

declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use PayNL\Sdk\{
    Model\PaymentMethod as PaymentMethodModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class PaymentMethod
 *
 * @package PayNL\Sdk\Transformer
 */
class PaymentMethod extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($inputToTransform)
    {
        $inputToTransform = $this->getDecodedInput($inputToTransform);

        $hydrator = new SimpleHydrator();

        $paymentMethods = &$inputToTransform['paymentMethods'];
        foreach ($paymentMethods as $key => $paymentMethodArray) {
            $paymentMethod = $hydrator->hydrate($paymentMethodArray, new PaymentMethodModel());
            $paymentMethods[$key] = $paymentMethod;
        }

        return $inputToTransform;
    }
}

<?php
declare(strict_types=1);

namespace PayNL\Sdk\Transformer;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\PaymentMethod as PaymentMethodModel;

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

        $hydrator = new ClassMethods();

        $paymentMethods = &$inputToTransform['paymentMethods'];
        foreach ($paymentMethods as $key => $paymentMethodArray) {
            $paymentMethod = $hydrator->hydrate($paymentMethodArray, new PaymentMethodModel());
            $paymentMethods[$key] = $paymentMethod;
        }

        return $inputToTransform;
    }

}

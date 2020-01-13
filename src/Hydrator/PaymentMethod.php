<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\PaymentMethod as PaymentMethodModel,
    Model\PaymentMethods as PaymentMethodsModel,
    Hydrator\PaymentMethods as PaymentMethodsHydrator
};

/**
 * Class PaymentMethod
 *
 * @package PayNL\Sdk\Hydrator
 */
class _PaymentMethod extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return PaymentMethodModel
     */
    public function hydrate(array $data, $object): PaymentMethodModel
    {
        $this->validateGivenObject($object, PaymentMethodModel::class);

        if (true === array_key_exists('subMethods', $data)) {
            if (false === is_array($data['subMethods'])) {
                $data['subMethods'] = [];
            }

            $data['subMethods'] = (new PaymentMethodsHydrator())
                ->hydrate($data['subMethods'], new PaymentMethodsModel())
            ;
        }

        /** @var PaymentMethodModel $paymentMethod */
        $paymentMethod = parent::hydrate($data, $object);
        return $paymentMethod;
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\PaymentMethod as PaymentMethodModel;
use PayNL\Sdk\Hydrator\PaymentMethods as PaymentMethodsHydrator;
use PayNL\Sdk\Model\PaymentMethods as PaymentMethodsModel;

/**
 * Class PaymentMethod
 *
 * @package PayNL\Sdk\Hydrator
 */
class PaymentMethod extends AbstractHydrator
{
    public function hydrate(array $data, $object): PaymentMethodModel
    {
        $this->validateGivenObject($object, PaymentMethodModel::class);

        $data['image'] = $data['image'] ?? '';

        if (true === array_key_exists('subId', $data) && true === empty($data['subId'])) {
            unset($data['subId']);
        }

        if (true === array_key_exists('subMethods', $data)) {
            if (false === is_array($data['subMethods'])) {
                $data['subMethods'] = [];
            }

            $data['subMethods'] = (new PaymentMethodsHydrator())->hydrate([
                'paymentMethods' => $data['subMethods']
            ], new PaymentMethodsModel());
        }

        /** @var PaymentMethodModel $paymentMethod */
        $paymentMethod = parent::hydrate($data, $object);
        return $paymentMethod;
    }
}

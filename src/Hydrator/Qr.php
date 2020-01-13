<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\PaymentMethod as PaymentMethodModel,
    Model\Qr as QrModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Qr
 *
 * @package PayNL\Sdk\Hydrator
 */
class _Qr extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return QrModel
     */
    public function hydrate(array $data, $object): QrModel
    {
        $this->validateGivenObject($object, QrModel::class);

        if (true === array_key_exists('paymentMethod', $data) && true === is_array($data['paymentMethod'])) {
            $data['paymentMethod'] = (new SimpleHydrator())->hydrate($data['paymentMethod'], new PaymentMethodModel());
        }

        /** @var QrModel $qr */
        $qr = parent::hydrate($data, $object);
        return $qr;
    }
}

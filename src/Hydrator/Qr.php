<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\{
    PaymentMethod,
    Qr as QrModel
};

/**
 * Class Qr
 *
 * @package PayNL\Sdk\Hydrator
 */
class Qr extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return QrModel
     */
    public function hydrate(array $data, $object): QrModel
    {
        if (true === array_key_exists('paymentMethod', $data) && false === $data['paymentMethod'] instanceof PaymentMethod) {
            $data['paymentMethod'] = (new ClassMethods())->hydrate($data['paymentMethod'], new PaymentMethod());
        }

        /** @var QrModel $qr */
        $qr = parent::hydrate($data, $object);
        return $qr;
    }
}

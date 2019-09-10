<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\{Card, PaymentMethod, Receipt as ReceiptModel};
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;

/**
 * Class Receipt
 *
 * @package PayNL\Sdk\Hydrator
 */
class Receipt extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException when given object is not an instance of Receipt model
     *
     * @return ReceiptModel
     */
    public function hydrate(array $data, $object): ReceiptModel
    {
        $validator = new ObjectInstanceValidator();
        if (false === $validator->isValid($object, ReceiptModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $validator->getMessages())
            );
        }

        if (true === array_key_exists('card', $data) && true === is_array($data['card'])) {
            $data['card'] = (new ClassMethods())->hydrate($data['card'], new Card());
        }

        if (true === array_key_exists('paymentMethod', $data) && true === is_array($data['paymentMethod'])) {
            $data['paymentMethod'] = (new ClassMethods())->hydrate($data['paymentMethod'], new PaymentMethod());
        }

        /** @var ReceiptModel $receipt */
        $receipt = parent::hydrate($data, $object);
        return $receipt;
    }
}

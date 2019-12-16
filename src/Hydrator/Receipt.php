<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Card as CardModel,
    Model\PaymentMethod as PaymentMethodModel,
    Model\Receipt as ReceiptModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Receipt
 *
 * @package PayNL\Sdk\Hydrator
 */
class Receipt extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ReceiptModel
     */
    public function hydrate(array $data, $object): ReceiptModel
    {
        $this->validateGivenObject($object, ReceiptModel::class);

        if (true === array_key_exists('card', $data) && true === is_array($data['card'])) {
            $data['card'] = (new SimpleHydrator())->hydrate($data['card'], new CardModel());
        }

        if (true === array_key_exists('paymentMethod', $data) && true === is_array($data['paymentMethod'])) {
            $data['paymentMethod'] = (new SimpleHydrator())->hydrate($data['paymentMethod'], new PaymentMethodModel());
        }

        /** @var ReceiptModel $receipt */
        $receipt = parent::hydrate($data, $object);
        return $receipt;
    }
}

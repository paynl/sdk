<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Amount as AmountModel,
    Model\Refund as RefundModel,
    Model\Products as ProductsModel,
    Model\BankAccount as BankAccountModel,
    Model\Status as StatusModel,
    Hydrator\Products as ProductsHydrator,
    Hydrator\Status as StatusHydrator,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Refund
 *
 * @package PayNL\Sdk\Hydrator
 */
class _Refund extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return RefundModel
     */
    public function hydrate(array $data, $object): RefundModel
    {
        $this->validateGivenObject($object, RefundModel::class);

        if (true === array_key_exists('bankAccount', $data) && true === is_array($data['bankAccount'])) {
            $data['bankAccount'] = (new SimpleHydrator())->hydrate($data['bankAccount'], new BankAccountModel());
        }

        if (true === array_key_exists('status', $data) && true === is_array($data['status'])) {
            $data['status'] = (new StatusHydrator())->hydrate($data['status'], new StatusModel());
        }

        if (true === array_key_exists('amount', $data) && true === is_array($data['amount'])) {
            $data['amount'] = (new SimpleHydrator())->hydrate($data['amount'], new AmountModel());
        }

        if (true === array_key_exists('products', $data) && true === is_array($data['products'])) {
            $data['products'] = (new ProductsHydrator())->hydrate($data['products'], new ProductsModel());
        }

        if (true === array_key_exists('processDate', $data) && null !== $data['processDate']) {
            $data['processDate'] = $this->getSdkDateTime($data['processDate']);
        }

        /** @var RefundModel $refund */
        $refund = parent::hydrate($data, $object);
        return $refund;
    }
}

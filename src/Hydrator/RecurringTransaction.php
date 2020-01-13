<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\RecurringTransaction as RecurringTransactionModel,
    Model\Amount as AmountModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class RecurringTransaction
 *
 * @package PayNL\Sdk\Hydrator
 */
class _RecurringTransaction extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return RecurringTransactionModel
     */
    public function hydrate(array $data, $object): RecurringTransactionModel
    {
        $this->validateGivenObject($object, RecurringTransactionModel::class);

        if (true === array_key_exists('amount', $data) && true === is_array($data['amount'])) {
            $data['amount'] = (new SimpleHydrator())->hydrate($data['amount'], new AmountModel());
        }

        /** @var RecurringTransactionModel $recurringTransaction */
        $recurringTransaction = parent::hydrate($data, $object);
        return $recurringTransaction;
    }
}

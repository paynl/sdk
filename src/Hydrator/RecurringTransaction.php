<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\{
    RecurringTransaction as RecurringTransactionModel,
    Amount
};

/**
 * Class RecurringTransaction
 *
 * @package PayNL\Sdk\Hydrator
 */
class RecurringTransaction extends AbstractHydrator
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
            $data['amount'] = (new ClassMethods())->hydrate($data['amount'], new Amount());
        }

        /** @var RecurringTransactionModel $recurringTransaction */
        $recurringTransaction = parent::hydrate($data, $object);
        return $recurringTransaction;
    }
}

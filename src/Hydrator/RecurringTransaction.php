<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Model\{RecurringTransaction as RecurringTransactionModel, Amount};
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;

/**
 * Class RecurringTransaction
 *
 * @package PayNL\Sdk\Hydrator
 */
class RecurringTransaction extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException when given object is not an instance of RecurringTransaction model
     *
     * @return RecurringTransactionModel
     */
    public function hydrate(array $data, $object): RecurringTransactionModel
    {
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, RecurringTransactionModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

        if (true === array_key_exists('amount', $data) && true === is_array($data['amount'])) {
            $data['amount'] = (new ClassMethods())->hydrate($data['amount'], new Amount());
        }

        /** @var RecurringTransactionModel $recurringTransaction */
        $recurringTransaction = parent::hydrate($data, $object);
        return $recurringTransaction;
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Directdebit as DirectdebitModel;
use PayNL\Sdk\Hydrator\{
    BankAccount as BankAccountHydrator,
    Status as StatusHydrator
};
use PayNL\Sdk\Model\{
    Amount,
    BankAccount,
    Status
};

/**
 * Class Directdebit
 *
 * @package PayNL\Sdk\Hydrator
 */
class Directdebit extends ClassMethods
{
    /**
     * Address constructor.
     *
     * @param bool $underscoreSeparatedKeys
     * @param bool $methodExistsCheck
     */
    public function __construct($underscoreSeparatedKeys = true, $methodExistsCheck = false)
    {
        // override the given params
        parent::__construct(false, true);
    }

    /**
     * @inheritDoc
     *
     * @return DirectdebitModel
     */
    public function hydrate(array $data, $object): DirectdebitModel
    {
        if (true === array_key_exists('amount', $data)) {
            $data['amount'] = (new ClassMethods())->hydrate($data['amount'], new Amount());
        }

        if (true === array_key_exists('bankAccount', $data)) {
            $data['bankAccount'] = (new BankAccountHydrator())->hydrate($data['bankAccount'], new BankAccount());
        }

        if (true === array_key_exists('status', $data) && null !== $data['status']['code']) {
            $data['status'] = (new StatusHydrator())->hydrate($data['status'], new Status());
        }

        if (true === array_key_exists('declined', $data) && null !== $data['declined']['code']) {
            $data['declined'] = (new StatusHydrator())->hydrate($data['declined'], new Status());
        }

        foreach (['status', 'declined'] as $statusField) {
            if (false === ($data[$statusField] instanceof Status)) {
                unset($data[$statusField]);
            }
        }

        /** @var DirectdebitModel $directdebit */
        $directdebit = parent::hydrate($data, $object);
        return $directdebit;
    }
}
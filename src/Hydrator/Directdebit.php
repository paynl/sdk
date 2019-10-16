<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Hydrator\{
    BankAccount as BankAccountHydrator,
    Status as StatusHydrator
};
use PayNL\Sdk\Model\{
    Amount,
    BankAccount,
    Directdebit as DirectdebitModel,
    Status
};

/**
 * Class Directdebit
 *
 * @package PayNL\Sdk\Hydrator
 */
class Directdebit extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return DirectdebitModel
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function hydrate(array $data, $object): DirectdebitModel
    {
        $this->validateGivenObject($object, DirectdebitModel::class);

        if (true === array_key_exists('amount', $data) && false === ($data['amount'] instanceof Amount)) {
            $data['amount'] = (new ClassMethods())->hydrate($data['amount'], new Amount());
        }

        if (true === array_key_exists('bankAccount', $data) && false === ($data['amount'] instanceof BankAccount)) {
            $data['bankAccount'] = (new BankAccountHydrator())->hydrate($data['bankAccount'], new BankAccount());
        }

        if (
            true === array_key_exists('status', $data)
            && false === ($data['status'] instanceof Status)
            && true === is_array($data['status'])
            && true === array_key_exists('code', $data['status'])
            && null !== $data['status']['code']
        ) {
            $data['status'] = (new StatusHydrator())->hydrate($data['status'], new Status());
        }

        if (
            true === array_key_exists('declined', $data)
            && false === ($data['declined'] instanceof Status)
            && true === is_array($data['declined'])
            && true === array_key_exists('code', $data['declined'])
            && null !== $data['declined']['code']
        ) {
            $data['declined'] = (new StatusHydrator())->hydrate($data['declined'], new Status());
        }

        foreach (['status', 'declined'] as $statusField) {
            if (false === array_key_exists($statusField, $data) || false === ($data[$statusField] instanceof Status)) {
                unset($data[$statusField]);
            }
        }

        /** @var DirectdebitModel $directdebit */
        $directdebit = parent::hydrate($data, $object);
        return $directdebit;
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\BankAccount as BankAccountModel;

/**
 * Class BankAccount
 *
 * @package PayNL\Sdk\Hydrator
 */
class BankAccount extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return BankAccountModel
     */
    public function hydrate(array $data, $object): BankAccountModel
    {
        $this->validateGivenObject($object, BankAccountModel::class);

        foreach (['iban', 'bic', 'owner'] as $optionalKey) {
            if (false === array_key_exists($optionalKey, $data) || true === empty($data[$optionalKey])) {
                $data[$optionalKey] = '';
            }
        }

        /** @var BankAccountModel $bankAccount */
        $bankAccount = parent::hydrate($data, $object);
        return $bankAccount;
    }
}

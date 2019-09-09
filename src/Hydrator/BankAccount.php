<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\BankAccount as BankAccountModel;

/**
 * Class BankAccount
 *
 * @package PayNL\Sdk\Hydrator
 */
class BankAccount extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return BankAccountModel
     */
    public function hydrate(array $data, $object): BankAccountModel
    {
        // TODO: ask Mike which keys are really optional
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

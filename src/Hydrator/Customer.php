<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\{
    BankAccount,
    Customer as CustomerModel
};
use PayNL\Sdk\Hydrator\BankAccount as BankAccountHydrator;
use Exception;

/**
 * Class Customer
 *
 * @package PayNL\Sdk\Hydrator
 */
class Customer extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @throws Exception
     *
     * @return CustomerModel
     */
    public function hydrate(array $data, $object): CustomerModel
    {
        $this->validateGivenObject($object, CustomerModel::class);

        if (true === array_key_exists('bankAccount', $data) && true === is_array($data['bankAccount'])) {
            $data['bankAccount'] =  (new BankAccountHydrator())->hydrate($data['bankAccount'], new BankAccount());
        }

        $data['trustLevel'] = $data['trustLevel'] ?? 0;
        $data['reference'] = $data['reference'] ?? 0;

        $optionalKeys = [
            'initials',
            'lastName',
            'gender',
            'phone',
            'email',
            'reference',
            'language',
            'ip',
        ];
        foreach ($optionalKeys as $optionalKey) {
            $data[$optionalKey] = $data[$optionalKey] ?? '';
        }

        if (true === array_key_exists('birthDate', $data)) {
            $birthDate = $data['birthDate'];
            if ($birthDate instanceof DateTime) {
                $birthDate = $birthDate->format(DateTime::ATOM);
            }
            $data['birthDate'] = (empty($data['birthDate']) === true ? null : DateTime::createFromFormat(DateTime::ATOM, $birthDate));
        }

        if (true === array_key_exists('birthDate', $data) && null === $data['birthDate']) {
            unset($data['birthDate']);
        }

        /** @var CustomerModel $customer */
        $customer = parent::hydrate($data, $object);
        return $customer;
    }
}

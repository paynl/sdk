<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\BankAccount as BankAccountModel,
    Model\Company as CompanyModel,
    Model\Customer as CustomerModel,
    Hydrator\Simple as SimpleHydrator
};

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
     * @return CustomerModel
     */
    public function hydrate(array $data, $object): CustomerModel
    {
        $this->validateGivenObject($object, CustomerModel::class);

        if (true === array_key_exists('birthDate', $data) && null !== $data['birthDate']) {
            $data['birthDate'] = $this->getSdkDateTime($data['birthDate']);
        }

        $data['trustLevel'] = (int)($data['trustLevel'] ?? 0);

        if (true === array_key_exists('bankAccount', $data) && true === is_array($data['bankAccount'])) {
            $data['bankAccount'] = (new SimpleHydrator())->hydrate($data['bankAccount'], new BankAccountModel());
        }

        if (true === array_key_exists('company', $data) && true === is_array($data['company'])) {
            $data['company'] = (new SimpleHydrator())->hydrate($data['company'], new CompanyModel());
        }

        /** @var CustomerModel $customer */
        $customer = parent::hydrate($data, $object);
        return $customer;
    }
}

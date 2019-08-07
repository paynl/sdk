<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\{BankAccount, Customer as CustomerModel};
use PayNL\Sdk\Hydrator\BankAccount as BankAccountHydrator;

/**
 * Class Customer
 *
 * @package PayNL\Sdk\Hydrator
 */
class Customer extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return CustomerModel
     */
    public function hydrate(array $data, $object): CustomerModel
    {
        if (true === array_key_exists('bankAccount', $data) && true === is_array($data['bankAccount'])) {
            $data['bankAccount'] =  (new BankAccountHydrator())->hydrate($data['bankAccount'], new BankAccount());
        }

        $optionalKeys = [
            'initials',
            'lastName',
            'gender',
            'phone',
            'email',
            'trustLevel',
            'reference',
            'language',
        ];
        foreach ($optionalKeys as $optionalKey) {
            if (false === array_key_exists($optionalKey, $data) || true === empty($data[$optionalKey])) {
                $data[$optionalKey] = '';
            }
        }
        if (true === array_key_exists('birthDate', $data) && false === empty($data['birthDate'])) {
            $data['birthDate'] = DateTime::createFromFormat(DateTime::ATOM, $data['birthDate']);
        } else {
            unset($data['birthDate']);
        }

        /** @var CustomerModel $customer */
        $customer = parent::hydrate($data, $object);
        return $customer;
    }
}

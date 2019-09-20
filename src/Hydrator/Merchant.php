<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use \Exception;
use PayNL\Sdk\DateTime;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Merchant as MerchantModel;
use PayNL\Sdk\Hydrator\{
    Address as AddressHydrator,
    BankAccount as BankAccountHydrator
};
use PayNL\Sdk\Model\{
    Address,
    BankAccount,
    ContactMethod,
    Trademark
};

/**
 * Class Merchant
 *
 * @package PayNL\Sdk\Hydrator
 */
class Merchant extends ClassMethods
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
     * @return MerchantModel
     */
    public function hydrate(array $data, $object): MerchantModel
    {
        $data['coc'] = $data['coc'] ?? '';
        $data['vat'] = $data['vat'] ?? '';
        $data['website'] = $data['website'] ?? '';

        if (true === array_key_exists('bankAccount', $data) && true === is_array($data['bankAccount'])) {
            $data['bankAccount'] = (new BankAccountHydrator())->hydrate($data['bankAccount'], new BankAccount());
        }

        $addressFields = [
            'postalAddress',
            'visitAddress',
        ];
        foreach ($addressFields as $addressField) {
            if (true === array_key_exists($addressField, $data) && true === is_array($data[$addressField])) {
                $data[$addressField] = (new AddressHydrator())->hydrate($data[$addressField], new Address());
            }
        }

        if (true === array_key_exists('trademarks', $data) && false === empty($data['trademarks'])) {
            foreach ($data['trademarks'] as &$tradeName) {
                $tradeName = (new ClassMethods())->hydrate($tradeName, new Trademark());
            }
            unset($tradeName);
        }

        if (true === array_key_exists('contactMethods', $data) && false === empty($data['contactMethods'])) {
            foreach ($data['contactMethods'] as &$contactMethod) {
                $contactMethod = (new ClassMethods())->hydrate($contactMethod, new ContactMethod());
            }
            unset($contactMethod);
        }

        if (true === array_key_exists('createdAt', $data) && '' !== $data['createdAt']) {
            $data['createdAt'] = DateTime::createFromFormat(DateTime::ATOM, $data['createdAt']);
        }

        /** @var MerchantModel $merchant */
        $merchant = parent::hydrate($data, $object);
        return $merchant;
    }
}

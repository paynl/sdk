<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Merchant as MerchantModel,
    Model\Address as AddressModel,
    Model\BankAccount as BankAccountModel,
    Model\ContactMethods as ContactMethodsModel,
    Model\Trademarks as TrademarksModel,
    Hydrator\Simple as SimpleHydrator,
    Hydrator\ContactMethods as ContactMethodsHydrator,
    Hydrator\Trademarks as TrademarksHydrator
};

/**
 * Class Merchant
 *
 * @package PayNL\Sdk\Hydrator
 */
class Merchant extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return MerchantModel
     */
    public function hydrate(array $data, $object): MerchantModel
    {
        $this->validateGivenObject($object, MerchantModel::class);

        if (true === array_key_exists('bankAccount', $data) && true === is_array($data['bankAccount'])) {
            $data['bankAccount'] = $this->hydratorManager->build('Simple')->hydrate($data['bankAccount'], $this->modelManager->build('BankAccount'));
        }

        foreach ([
            'postalAddress',
            'visitAddress',
        ] as $addressField) {
            if (true === array_key_exists($addressField, $data) && true === is_array($data[$addressField])) {
                $data[$addressField] = $this->hydratorManager->build('Simple')->hydrate($data[$addressField], $this->modelManager->build('Address'));
            }
        }

        if (true === array_key_exists('trademarks', $data) && true === is_array($data['trademarks'])) {
            $data['trademarks'] = $this->hydratorManager->build('Trademarks')->hydrate($data['trademarks'], $this->modelManager->build('Trademarks'));
        }

        if (true === array_key_exists('contactMethods', $data) && true === is_array($data['contactMethods'])) {
            $data['contactMethods'] = $this->hydratorManager->build('ContactMethods')
                ->hydrate($data['contactMethods'], $this->modelManager->build('ContactMethods'))
            ;
        }

        if (true === array_key_exists('createdAt', $data) && null !== $data['createdAt']) {
            $data['createdAt'] = $this->getSdkDateTime($data['createdAt']);
        }

        /** @var MerchantModel $merchant */
        $merchant = parent::hydrate($data, $object);
        return $merchant;
    }
}

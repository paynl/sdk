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
    BankAccount
};

/**
 * Class Merchant
 *
 * @package PayNL\Sdk\Hydrator
 */
class Merchant extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @throws Exception
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

//        if (true === array_key_exists('tradeNames', $data) && false === empty($data['tradeNames'])) {
//            foreach ($data['tradeNames'] as &$tradeName) {
//                $tradeName = (new TradeNameHydrator())->hydrate($tradeName, new TradeName());
//            }
//        }

//        if (true === array_key_exists('contactMethods', $data) && false === empty($data['contactMethods'])) {
//            foreach ($data['contactMethods'] as &$contactMethod) {
//                $tradeName = (new ContactMethodHydrator())->hydrate($contactMethod, new ContactMethod());
//            }
//        }

        if (true === array_key_exists('createdAt', $data) && '' !== $data['createdAt']) {
            $data['createdAt'] = DateTime::createFromFormat(DateTime::ATOM, $data['createdAt']);
        }

        /** @var MerchantModel $merchant */
        $merchant = parent::hydrate($data, $object);
        return $merchant;
    }
}

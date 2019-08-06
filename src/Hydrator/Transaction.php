<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use \DateTime;
use PayNL\Sdk\Model\{
    Address,
    Amount,
    Customer,
    Exchange,
    PaymentMethod,
    Product,
    Statistics,
    Status,
    Transaction as TransactionModel
};
use PayNL\Sdk\Hydrator\{
    Address as AddressHydrator,
    Customer as CustomerHydrator,
    Exchange as ExchangeHydrator,
    Product as ProductHydrator,
    Status as StatusHydrator,
    Statistics as StatisticsHydrator
};
use Zend\Hydrator\ClassMethods;

/**
 * Class Transaction
 *
 * @package PayNL\Sdk\Hydrator
 */
class Transaction extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return TransactionModel
     */
    public function hydrate(array $data, $object): TransactionModel
    {
        if (true === array_key_exists('status', $data) && true === is_array($data['status'])) {
            $data['status'] =  (new StatusHydrator())->hydrate($data['status'], new Status());
        }
        if (true === array_key_exists('exchange', $data) && true === is_array($data['exchange'])) {
            $data['exchange'] =  (new ExchangeHydrator())->hydrate($data['exchange'], new Exchange());
        }
        if (true === array_key_exists('paymentMethod', $data) && true === is_array($data['paymentMethod'])) {
            $data['paymentMethod'] = (new ClassMethods())->hydrate($data['paymentMethod'], new PaymentMethod());
        }
        foreach (['address', 'billingAddress'] as $addressKey) {
            if (true === array_key_exists($addressKey, $data) && true === is_array($data[$addressKey])) {
                $data[$addressKey] = (new AddressHydrator())->hydrate($data[$addressKey], new Address());
            }
        }
        if (true === array_key_exists('customer', $data) && true === is_array($data['customer'])) {
            $data['customer'] = (new CustomerHydrator())->hydrate($data['customer'], new Customer());
        }
        if (true === array_key_exists('statistics', $data) && true === is_array($data['statistics'])) {
            $data['statistics'] = (new StatisticsHydrator())->hydrate($data['statistics'], new Statistics());
        }

        $amountFields = [
            'amount',
            'amountConverted',
            'amountPaid',
            'amountRefunded',
        ];
        foreach ($amountFields as $amountField) {
            if (true === array_key_exists($amountField, $data) && true === is_array($data[$amountField])) {
                $data[$amountField] = (new ClassMethods())->hydrate($data[$amountField], new Amount());
            }
        }

        if (
            true === array_key_exists('products', $data) &&
            true === is_array($data['products']) &&
            0 < sizeof($data['products'])
        ) {
            foreach ($data['products'] as $key => &$product) {
                $product = (new ProductHydrator())->hydrate($product, new Product());
            }
            unset($product);
        }

        $dateFields = [
            'invoiceDate',
            'deliveryDate',
            'createdAt',
            'expiresAt',
        ];
        foreach($dateFields as $dateField) {
            if (true === array_key_exists($dateField, $data) && '' !== $data[$dateField]) {
                $data[$dateField] = DateTime::createFromFormat(DateTime::ATOM, $data[$dateField]);
            } else {
                unset($data[$dateField]);
            }
        }

        $optionalFields = [
            'returnUrl',
            'issuerUrl',
            'reference',
        ];
        foreach ($optionalFields as $optionalField) {
            if (false === array_key_exists($optionalField, $data) || true === empty($data[$optionalField])) {
                $data[$optionalField] = '';
            }
        }

        /** @var TransactionModel $transaction */
        $transaction = parent::hydrate($data, $object);
        return $transaction;
    }
}

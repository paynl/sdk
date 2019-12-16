<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Address as AddressModel,
    Model\Customer as CustomerModel,
    Model\Order as OrderModel,
    Model\Products as ProductsModel,
    Hydrator\Customer as CustomerHydrator,
    Hydrator\Products as ProductsHydrator,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Order
 *
 * @package PayNL\Sdk\Hydrator
 */
class Order extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return OrderModel
     */
    public function hydrate(array $data, $object): OrderModel
    {
        foreach ([
            'deliveryDate',
            'invoiceDate',
        ] as $dateField) {
            if (true === array_key_exists($dateField, $data) && null !== $data[$dateField]) {
                $data[$dateField] = $this->getSdkDateTime($data[$dateField]);
            }
        }

        foreach ([
            'deliveryAddress',
            'invoiceAddress'
        ] as $addressKey) {
            if (true === array_key_exists($addressKey, $data) && true === is_array($data[$addressKey])) {
                $data[$addressKey] = (new SimpleHydrator())->hydrate($data[$addressKey], new AddressModel());
            }
        }

        if (true === array_key_exists('customer', $data) && true === is_array($data['customer'])) {
            $data['customer'] = (new CustomerHydrator())->hydrate($data['customer'], new CustomerModel());
        }

        if (true === array_key_exists('products', $data) && true === is_array($data['products'])) {
            $data['products'] = (new ProductsHydrator())->hydrate($data['products'], new ProductsModel());
        }

        /** @var OrderModel $order */
        $order = parent::hydrate($data, $object);
        return $order;
    }
}

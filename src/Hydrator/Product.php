<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Amount as AmountModel,
    Model\Product as ProductModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Product
 *
 * @package PayNL\Sdk\Hydrator
 */
class _Product extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ProductModel
     */
    public function hydrate(array $data, $object): ProductModel
    {
        $this->validateGivenObject($object, ProductModel::class);

        if (true === array_key_exists('price', $data) && true === is_array($data['price'])) {
            $data['price'] = (new SimpleHydrator())->hydrate($data['price'], new AmountModel());
        }

        /** @var ProductModel $product */
        $product = parent::hydrate($data, $object);
        return $product;
    }
}

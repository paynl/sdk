<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Product as ProductModel,
    Model\Products as ProductsModel,
    Hydrator\Product as ProductHydrator
};

/**
 * Class Products
 *
 * @package PayNL\Sdk\Hydrator
 */
class Products extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ProductsModel
     */
    public function hydrate(array $data, $object): ProductsModel
    {
        $this->validateGivenObject($object, ProductsModel::class);

        if (false === array_key_exists('products', $data)) {
            // expect given array is the array of products
            $data = array(
                'products' => $data
            );
        }

        foreach ($data['products'] as $key => $product) {
            if (false === ($product instanceof ProductModel)) {
                $data['products'][$key] = (new ProductHydrator())->hydrate($product, new ProductModel());
            }
        }

        /** @var ProductsModel $products */
        $products = parent::hydrate($data, $object);
        return $products;
    }
}

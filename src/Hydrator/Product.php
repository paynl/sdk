<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Model\Amount;
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Product as ProductModel;

/**
 * Class Product
 *
 * @package PayNL\Sdk\Hydrator
 */
class Product extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException when given object is not a Product model
     *
     * @return ProductModel
     */
    public function hydrate(array $data, $object): ProductModel
    {
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, ProductModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

        if (true === array_key_exists('price', $data) && true === is_array($data['price'])) {
            $data['price'] = (new ClassMethods())->hydrate($data['price'], new Amount());
        }

        /** @var ProductModel $product */
        $product = parent::hydrate($data, $object);
        return $product;
    }
}

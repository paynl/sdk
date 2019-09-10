<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use \Exception;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\{Amount, Refund as RefundModel, Product, BankAccount, Status};
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Hydrator\{
    BankAccount as BankAccountHydrator,
    Product as ProductHydrator,
    Status as StatusHydrator
};

/**
 * Class Refund
 *
 * @package PayNL\Sdk\Hydrator
 */
class Refund extends ClassMethods
{
    /**
     * @param array $data
     * @param object $object
     *
     * @throws InvalidArgumentException when given object is not an instance of Refund model
     *
     * @return RefundModel
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function hydrate(array $data, $object): RefundModel
    {
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, RefundModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

        $data['description'] = $data['description'] ?? '';

        if (true === array_key_exists('bankAccount', $data) && true === is_array($data['bankAccount'])) {
            if (true === array_key_exists('number', $data['bankAccount'])) {
                $data['bankAccount']['iban'] = $data['bankAccount']['number'];
                unset($data['bankAccount']['number']);
            }
            $data['bankAccount'] = (new BankAccountHydrator())->hydrate($data['bankAccount'], new BankAccount());
        }

        if (true === array_key_exists('status', $data) && true === is_array($data['status'])) {
            $data['status'] = (new StatusHydrator())->hydrate($data['status'], new Status());
        }

        if (true === array_key_exists('amount', $data) && true === is_array($data['amount'])) {
            $data['amount'] = (new ClassMethods())->hydrate($data['amount'], new Amount());
        }

        if (true === array_key_exists('products', $data) && 0 < count($data['products'])) {
            $data['products'] = array_map(static function ($product) {
                if (true === is_array($product)) {
                    return (new ProductHydrator())->hydrate($product, new Product());
                }
                return $product;
            }, $data['products']);
        }

        if (true === array_key_exists('processedDate', $data)) {
            $data['processDate'] = $data['processedDate'];
            unset($data['processedDate']);
        }

        if (true === array_key_exists('processDate', $data) && false === empty($data['processDate'])) {
            $data['processDate'] = DateTime::createFromFormat(DateTime::ATOM, $data['processDate']);
        }

        /** @var RefundModel $refund */
        $refund = parent::hydrate($data, $object);
        return $refund;
    }
}

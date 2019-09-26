<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\{
    Amount,
    Voucher as VoucherModel
};

/**
 * Class Voucher
 *
 * @package PayNL\Sdk\Hydrator
 */
class Voucher extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return VoucherModel
     */
    public function hydrate(array $data, $object): VoucherModel
    {
        if (true === array_key_exists('amount', $data)) {
            $data['amount'] = (new ClassMethods())->hydrate($data['amount'], new Amount());
        }

        /** @var VoucherModel $voucher */
        $voucher = parent::hydrate($data, $object);
        return $voucher;
    }
}

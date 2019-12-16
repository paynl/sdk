<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Amount as AmountModel,
    Model\Voucher as VoucherModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Voucher
 *
 * @package PayNL\Sdk\Hydrator
 */
class Voucher extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return VoucherModel
     */
    public function hydrate(array $data, $object): VoucherModel
    {
        $this->validateGivenObject($object, VoucherModel::class);

        if (true === array_key_exists('amount', $data)) {
            $data['amount'] = (new SimpleHydrator())->hydrate($data['amount'], new AmountModel());
        }

        /** @var VoucherModel $voucher */
        $voucher = parent::hydrate($data, $object);
        return $voucher;
    }
}

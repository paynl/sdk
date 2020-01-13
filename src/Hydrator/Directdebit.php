<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Amount as AmountModel,
    Model\BankAccount as BankAccountModel,
    Model\Directdebit as DirectdebitModel,
    Model\Status as StatusModel,
    Hydrator\Status as StatusHydrator,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Directdebit
 *
 * @package PayNL\Sdk\Hydrator
 */
class _Directdebit extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return DirectdebitModel
     */
    public function hydrate(array $data, $object): DirectdebitModel
    {
        $this->validateGivenObject($object, DirectdebitModel::class);

        if (true === array_key_exists('amount', $data) && true === is_array($data['amount'])) {
            $data['amount'] = (new SimpleHydrator())->hydrate($data['amount'], new AmountModel());
        }

        if (true === array_key_exists('bankAccount', $data) && true === is_array($data['bankAccount'])) {
            $data['bankAccount'] = (new SimpleHydrator())->hydrate($data['bankAccount'], new BankAccountModel());
        }

        foreach ([
            'status',
            'declined'
        ] as $statusFieldKey) {
            if (true === array_key_exists($statusFieldKey, $data) && true === is_array($data[$statusFieldKey])) {
                $data[$statusFieldKey] = (new StatusHydrator())->hydrate($data[$statusFieldKey], new StatusModel());
            }
        }

        /** @var DirectdebitModel $directdebit */
        $directdebit = parent::hydrate($data, $object);
        return $directdebit;
    }
}

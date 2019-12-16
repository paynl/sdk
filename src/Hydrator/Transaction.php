<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Exception;
use PayNL\Sdk\{
    Model\Amount as AmountModel,
    Model\PaymentMethod as PaymentMethodModel,
    Model\Integration as IntegrationModel,
    Model\Order as OrderModel,
    Model\Transaction as TransactionModel,
    Model\TransactionStatus as TransactionStatusModel,
    Model\Statistics as StatisticsModel,
    Model\Transfer as TransferModel,
    Hydrator\Simple as SimpleHydrator,
    Hydrator\PaymentMethod as PaymentMethodHydrator,
    Hydrator\Order as OrderHydrator,
    Hydrator\Status as StatusHydrator
};

/**
 * Class Transaction
 *
 * @package PayNL\Sdk\Hydrator
 */
class Transaction extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return TransactionModel
     */
    public function hydrate(array $data, $object): TransactionModel
    {
        $this->validateGivenObject($object, TransactionModel::class);

        foreach ([
            'expiresAt',
            'createdAt',
        ] as $dateTimeFieldKey) {
            if (true === array_key_exists($dateTimeFieldKey, $data) && null !== $data[$dateTimeFieldKey]) {
                $data[$dateTimeFieldKey] = $this->getSdkDateTime($data[$dateTimeFieldKey]);
            }
        }

        foreach ([
            'amount',
            'amountConverted',
            'amountPaid',
            'amountRefunded',
        ] as $amountFieldKey) {
            if (true === array_key_exists($amountFieldKey, $data) && true === is_array($data[$amountFieldKey])) {
                $data[$amountFieldKey] = (new SimpleHydrator())->hydrate($data[$amountFieldKey], new AmountModel());
            }
        }

        if (true === array_key_exists('paymentMethod', $data) && true === is_array($data['paymentMethod'])) {
            $data['paymentMethod'] = (new PaymentMethodHydrator())->hydrate($data['paymentMethod'], new PaymentMethodModel());
        }

        if (true === array_key_exists('integration', $data) && true === is_array($data['integration'])) {
            $data['integration'] = (new SimpleHydrator())->hydrate($data['integration'], new IntegrationModel());
        }

        if (true === array_key_exists('transfer', $data) && true === is_array($data['transfer'])) {
            $data['transfer'] = (new SimpleHydrator())->hydrate($data['transfer'], new TransferModel());
        }

        if (true === array_key_exists('order', $data) && true === is_array($data['order'])) {
            $data['order'] = (new OrderHydrator())->hydrate($data['order'], new OrderModel());
        }

        if (true === array_key_exists('status', $data) && true === is_array($data['status'])) {
            $data['status'] = (new StatusHydrator())->hydrate($data['status'], new TransactionStatusModel());
        }

        if (true === array_key_exists('statistics', $data) && true === is_array($data['statistics'])) {
            $data['statistics'] = (new SimpleHydrator())->hydrate($data['statistics'], new StatisticsModel());
        }

        /** @var TransactionModel $transaction */
        $transaction = parent::hydrate($data, $object);
        return $transaction;
    }
}

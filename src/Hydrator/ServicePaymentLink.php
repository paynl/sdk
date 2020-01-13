<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Amount as AmountModel,
    Model\Statistics as StatisticsModel,
    Model\ServicePaymentLink as ServicePaymentLinkModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class ServicePaymentLink
 *
 * @package PayNL\Sdk\Hydrator
 */
class _ServicePaymentLink extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ServicePaymentLinkModel
     */
    public function hydrate(array $data, $object): ServicePaymentLinkModel
    {
        $this->validateGivenObject($object, ServicePaymentLinkModel::class);

        if (true === array_key_exists('amount', $data) && true === is_array($data['amount'])) {
            $data['amount'] = (new SimpleHydrator())->hydrate($data['amount'], new AmountModel());
        }

        if (true === array_key_exists('amountMin', $data) && true === is_array($data['amountMin'])) {
            $data['amountMin'] = (new SimpleHydrator())->hydrate($data['amountMin'], new AmountModel());
        }

        if (true === array_key_exists('statistics', $data) && true === is_array($data['statistics'])) {
            $data['statistics'] = (new SimpleHydrator())->hydrate($data['statistics'], new StatisticsModel());
        }

        /** @var ServicePaymentLinkModel $servicePaymentLink */
        $servicePaymentLink = parent::hydrate($data, $object);
        return $servicePaymentLink;
    }
}

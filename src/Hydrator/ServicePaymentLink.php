<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\{
    Amount,
    Statistics,
    ServicePaymentLink as ServicePaymentLinkModel
};
use PayNL\Sdk\Hydrator\Statistics as StatisticsHydrator;
use Zend\Hydrator\ClassMethods;

/**
 * Class ServicePaymentLink
 *
 * @package PayNL\Sdk\Hydrator
 */
class ServicePaymentLink extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ServicePaymentLinkModel
     */
    public function hydrate(array $data, $object): ServicePaymentLinkModel
    {
        $this->validateGivenObject($object, ServicePaymentLinkModel::class);

        if (true === array_key_exists('amount', $data)) {
            $data['amount'] = (new ClassMethods())->hydrate($data['amount'], new Amount());
        }

        if (true === array_key_exists('amountMin', $data)) {
            $data['amountMin'] = (new ClassMethods())->hydrate($data['amountMin'], new Amount());
        }

        $data['countryCode'] = $data['countryCode'] ?? '';
        $data['language'] = $data['language'] ?? '';

        if (true === array_key_exists('statistics', $data)) {
            $data['statistics'] = (new StatisticsHydrator())->hydrate($data['statistics'], new Statistics());
        }

        /** @var ServicePaymentLinkModel $servicePaymentLink */
        $servicePaymentLink = parent::hydrate($data, $object);
        return $servicePaymentLink;
    }
}

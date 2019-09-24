<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\{
    Amount,
    Statistics
};
use PayNL\Sdk\Hydrator\Statistics as StatisticsHydrator;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\ServicePaymentLink as ServicePaymentLinkModel;

/**
 * Class ServicePaymentLink
 *
 * @package PayNL\Sdk\Hydrator
 */
class ServicePaymentLink extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return ServicePaymentLinkModel
     */
    public function hydrate(array $data, $object): ServicePaymentLinkModel
    {
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

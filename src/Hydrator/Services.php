<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Services as ServicesModel,
    Model\Service as ServiceModel,
    Hydrator\Service as ServiceHydrator
};

/**
 * Class Services
 *
 * @package PayNL\Sdk\Hydrator
 */
class Services extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ServicesModel
     */
    public function hydrate(array $data, $object): ServicesModel
    {
        $this->validateGivenObject($object, ServicesModel::class);

        // "reset" total
        $data['total'] = 0;
        foreach ($data['services'] as $key => $currency) {
            $data['services'][$key] = (new ServiceHydrator())->hydrate($currency, new ServiceModel());
        }

        /** @var ServicesModel $services */
        $services = parent::hydrate($data, $object);
        return $services;
    }
}

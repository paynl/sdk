<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\Service as ServiceModel;

/**
 * Class Service
 *
 * @package PayNL\Sdk\Hydrator
 */
class _Service extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ServiceModel
     */
    public function hydrate(array $data, $object): ServiceModel
    {
        $this->validateGivenObject($object, ServiceModel::class);

        if (true === array_key_exists('createdAt', $data) && null !== $data['createdAt']) {
            $data['createdAt'] = $this->getSdkDateTime($data['createdAt']);
        }

        /** @var ServiceModel $service */
        $service = parent::hydrate($data, $object);
        return $service;
    }
}

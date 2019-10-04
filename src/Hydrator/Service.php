<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\Service as ServiceModel;

/**
 * Class Service
 *
 * @package PayNL\Sdk\Hydrator
 */
class Service extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ServiceModel
     */
    public function hydrate(array $data, $object): ServiceModel
    {
        $this->validateGivenObject($object, ServiceModel::class);

        $data['description'] = $data['description'] ?? '';
        $data['testMode']    = $data['testMode'] ?? 0;
        $data['secret']      = $data['secret'] ?? '';

        $dateField = 'createdAt';
        if (true === array_key_exists($dateField, $data)) {
            $createdDate = $data[$dateField];
            if ($createdDate instanceof DateTime) {
                $createdDate = $createdDate->format(DateTime::ATOM);
            }
            $data[$dateField] = empty($data[$dateField]) === true ? null : DateTime::createFromFormat(DateTime::ATOM, $createdDate);
        }

        /** @var ServiceModel $service */
        $service = parent::hydrate($data, $object);
        return $service;
    }
}

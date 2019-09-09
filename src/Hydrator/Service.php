<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use \Exception;
use PayNL\Sdk\DateTime;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Service as ServiceModel;

/**
 * Class Service
 *
 * @package PayNL\Sdk\Hydrator
 */
class Service extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @throws Exception
     *
     * @return ServiceModel
     */
    public function hydrate(array $data, $object): ServiceModel
    {
        $data['description'] = $data['description'] ?? '';
        $data['testMode']    = $data['testMode'] ?? 0;
        $data['secret']      = $data['secret'] ?? '';

        $dateField = 'createdAt';
        if (true === array_key_exists($dateField, $data)) {
            $data[$dateField] = empty($data[$dateField]) === true ? null : DateTime::createFromFormat(DateTime::ATOM, $data[$dateField]);
        }

        /** @var ServiceModel $service */
        $service = parent::hydrate($data, $object);
        return $service;
    }
}

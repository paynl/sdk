<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Exchange as ExchangeModel;

/**
 * Class Exchange
 *
 * @package PayNL\Sdk\Hydrator
 */
class Exchange extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return ExchangeModel
     */
    public function hydrate(array $data, $object): ExchangeModel
    {
        // TODO method and type support will be added to the REST API (in time.... - 2030?)
        foreach (['method', 'type', 'url'] as $optionalKey) {
            if (false === array_key_exists($optionalKey, $data) || true === empty($data[$optionalKey])) {
                $data[$optionalKey] = '';
            }
        }

        /** @var ExchangeModel $exchange */
        $exchange = parent::hydrate($data, $object);
        return $exchange;
    }
}
<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Statistics as StatisticsModel;

/**
 * Class Statistics
 *
 * @package PayNL\Sdk\Hydrator
 */
class Statistics extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return StatisticsModel
     */
    public function hydrate(array $data, $object): StatisticsModel
    {
        $optionalFields = [
            'promoterId',
            'info',
            'tool',
            'extra1',
            'extra2',
            'extra3',
        ];

        foreach ($optionalFields as $optionalField) {
            if (false === array_key_exists($optionalField, $data) || true === empty($data[$optionalField])) {
                $data[$optionalField] = '';
            }
        }
        if (false === array_key_exists('transferData', $data)) {
            $data['transferData'] = [];
        }

        /** @var StatisticsModel $statistics */
        $statistics = parent::hydrate($data, $object);
        return $statistics;
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use DateTime as stdDateTime;
use PayNL\Sdk\{
    DateTime,
    Model\Amount as AmountModel,
    Model\Mandate as MandateModel,
    Model\Statistics as StatisticsModel,
    Model\Interval as IntervalModel,
    Model\Customer as CustomerModel,
    Hydrator\Simple as SimpleHydrator,
    Hydrator\Customer as CustomerHydrator
};

/**
 * Class Mandate
 *
 * @package PayNL\Sdk\Hydrator
 */
class Mandate extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return MandateModel
     */
    public function hydrate(array $data, $object): MandateModel
    {
        $this->validateGivenObject($object, MandateModel::class);

        if (true === array_key_exists('processDate', $data) && false === ($data['processDate'] instanceof DateTime)) {
            $processDate = $data['processDate'];
            if ($processDate instanceof stdDateTime) {
                $processDate = $processDate->format(stdDateTime::ATOM);
            }
            $data['processDate'] = DateTime::createFromFormat(DateTime::ATOM, $processDate);
        }

        if (true === array_key_exists('amount', $data)) {
            $data['amount'] = (new SimpleHydrator())->hydrate($data['amount'], new AmountModel());
        }

        if (true === array_key_exists('statistics', $data)) {
            $data['statistics'] = (new SimpleHydrator())->hydrate($data['statistics'], new StatisticsModel());
        }

        if (true === array_key_exists('interval', $data)) {
            $data['interval'] = (new SimpleHydrator())->hydrate($data['interval'], new IntervalModel());
        }

        if (true === array_key_exists('customer', $data)) {
            $data['customer'] = (new CustomerHydrator())->hydrate($data['customer'], new CustomerModel());
        }

        /** @var MandateModel $mandate */
        $mandate = parent::hydrate($data, $object);
        return $mandate;
    }
}

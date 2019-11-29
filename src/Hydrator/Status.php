<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Exception;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\Status as StatusModel;

/**
 * Class Status
 *
 * @package PayNL\Sdk\Hydrator
 */
class Status extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @throws Exception
     *
     * @return StatusModel
     */
    public function hydrate(array $data, $object): StatusModel
    {
        $this->validateGivenObject($object, StatusModel::class);

        if (true === array_key_exists('date', $data)) {
            $date = $data['date'];
            if ($date instanceof DateTime) {
                $date = $date->format(DateTime::ATOM);
            }
            $data['date'] = empty($data['date']) === true ? null : DateTime::createFromFormat(DateTime::ATOM, $date);
        }

        if (false === array_key_exists('reason', $data) || true === empty($data['reason'])) {
            $data['reason'] = '';
        }

        if (true === array_key_exists('date', $data) && null === $data['date']) {
            unset($data['date']);
        }

        /** @var StatusModel $status */
        $status = parent::hydrate($data, $object);
        return $status;
    }
}

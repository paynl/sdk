<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\Status as StatusModel;

/**
 * Class Status
 *
 * @package PayNL\Sdk\Hydrator
 */
class _Status extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return StatusModel
     */
    public function hydrate(array $data, $object): StatusModel
    {
        $this->validateGivenObject($object, StatusModel::class);

        if (true === array_key_exists('date', $data) && null !== $data['date']) {
            $data['date'] = $this->getSdkDateTime($data['date']);
        }

        /** @var StatusModel $status */
        $status = parent::hydrate($data, $object);
        return $status;
    }
}

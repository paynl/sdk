<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\Errors as ErrorsModel;

/**
 * Class Errors
 *
 * @package PayNL\Sdk\Hydrator
 */
class Errors extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return ErrorsModel
     */
    public function hydrate(array $data, $object): ErrorsModel
    {
        $this->validateGivenObject($object, ErrorsModel::class);

        /** @var ErrorsModel $errors */
        $errors = parent::hydrate($data, $object);
        return $errors;
    }
}

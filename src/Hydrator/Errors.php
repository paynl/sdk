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

        if (false === array_key_exists('errors', $data)) {
            // assume data is an array of errors
            $data = [
                'errors' => $data,
            ];
        }

        /** @var ErrorsModel $errors */
        $errors = parent::hydrate($data, $object);
        return $errors;
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

/**
 * Interface ValidatorInterface
 *
 * @package PayNL\Sdk\Validator
 */
interface ValidatorInterface
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value): bool;

    /**
     * @return array
     */
    public function getMessages(): array;
}

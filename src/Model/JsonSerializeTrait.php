<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Exception\LogicException;

/**
 * Trait JsonSerializeTrait
 *
 * @package PayNL\Sdk\Model
 */
trait JsonSerializeTrait
{
    /**
     * @see \JsonSerializable::jsonSerialize()
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $this->checkInterfaceImplementation();

        $var = get_object_vars($this);
        foreach ($var as &$value) {
            if (is_object($value) === true && method_exists($value, 'jsonSerialize') === true) {
                $value = $value->jsonSerialize();
            }
        }
        return $var;
    }

    /**
     * Internal method to check if the current object which
     * uses the trait and tries to json serialize implement
     * the correct interface
     *
     * @return void
     * @throws LogicException
     */
    protected function checkInterfaceImplementation(): void
    {
        if (false === ($this instanceof \JsonSerializable)) {
            throw new LogicException(sprintf(
                'Class %s should implement the interface JsonSerializable',
                __CLASS__
            ));
        }
    }
}

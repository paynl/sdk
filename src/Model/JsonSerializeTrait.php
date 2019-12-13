<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Exception\LogicException;

/**
 * Trait JsonSerializeTrait
 *
 * @package PayNL\Sdk\Model
 */
trait JsonSerializeTrait
{
    /**
     * @see JsonSerializable::jsonSerialize()
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $this->checkInterfaceImplementation();

        $var = array_filter(get_object_vars($this), static function ($var, $key) {
            if (true === is_array($var)) {
                return 0 < count($var);
            }

            if (1 === preg_match('/^(?P<idKey>id$|(.*)Id)$/', $key, $match) && 0 === (int)$match['idKey']) {
                return false;
            }

            return null !== $var && '' !== $var;
        }, ARRAY_FILTER_USE_BOTH);

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
        if (false === ($this instanceof JsonSerializable)) {
            throw new LogicException(sprintf(
                'Class %s should implement the interface %s',
                __CLASS__,
                JsonSerializable::class
            ));
        }
    }
}

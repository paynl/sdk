<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use JsonSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Exception\{
    LogicException,
    RuntimeException
};

/**
 * Trait JsonSerializeTrait
 *
 * @package PayNL\Sdk\Common
 */
trait JsonSerializeTrait
{
    /**
     * @see JsonSerializable::jsonSerialize()
     *
     * @throws RuntimeException when object is not valid based on the required members
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $this->checkInterfaceImplementation();

        $vars = get_object_vars($this);
        if ($this instanceof ArrayCollection) {
            return $this->toArray();
        }

        return array_filter($vars, static function (&$var) {
            if (true === is_object($var) && true === method_exists($var, 'jsonSerialize')) {
                /** @var JsonSerializable $var */
                $var = $var->jsonSerialize();
            }

            if (true === is_array($var)) {
                return 0 < count($var);
            }

            return null !== $var && '' !== $var;
        });
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

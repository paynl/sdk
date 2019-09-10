<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Terminal as TerminalModel;

/**
 * Class Terminal
 *
 * @package PayNL\Sdk\Hydrator
 */
class Terminal extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException when given object is not an instance of Terminal model
     *
     * @return TerminalModel
     */
    public function hydrate(array $data, $object): TerminalModel
    {
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, TerminalModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

        /** @var TerminalModel $terminal */
        $terminal = parent::hydrate($data, $object);
        return $terminal;
    }
}

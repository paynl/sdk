<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

/**
 * Class ObjectInstanceValidator
 *
 * @package PayNL\Sdk\Validator
 */
class ObjectInstance extends AbstractValidator
{
    /*
     * Message type constant definitions
     */
    protected const MSG_NO_CLASS_NAME       = 'NoClassName';
    protected const MSG_VALUE_NOT_AN_OBJECT = 'ValueNotAnObject';
    protected const MSG_WRONG_INSTANCE      = 'WrongInstance';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::MSG_NO_CLASS_NAME       => 'No class name given to check upon',
        self::MSG_VALUE_NOT_AN_OBJECT => 'Given value is not an object',
        self::MSG_WRONG_INSTANCE      => '%s is not an instance of %s',
    ];

    /**
     * @inheritDoc
     * @param string|null $className
     */
    public function isValid($value, string $className = null): bool
    {
        if (null === $className) {
            $this->error(self::MSG_NO_CLASS_NAME);
        }

        if (false === is_object($value)) {
            $this->error(self::MSG_VALUE_NOT_AN_OBJECT);
        }

        // only validate when previous errors aren't triggered
        // make sure $className is a string otherwise PHP will freak!
        $className = (string)$className;
        if (false === ($value instanceof $className) && 0 === count($this->getMessages())) {
            $this->error(self::MSG_WRONG_INSTANCE, get_class($value), $className);
        }

        return 0 === count($this->getMessages());
    }
}

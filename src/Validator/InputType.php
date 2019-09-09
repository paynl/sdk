<?php
declare(strict_types=1);

namespace PayNL\Sdk\Validator;

/**
 * Class InputType
 *
 * @package PayNL\Sdk\Validator
 */
class InputType extends AbstractValidator
{
    /*
     * Message type constant definitions
     */
    protected const MSG_NO_TYPE            = 'NoType';
    protected const MSG_VALUE_IS_AN_OBJECT = 'ValueIsAnObject';
    protected const MSG_WRONG_TYPE         = 'WrongType';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::MSG_NO_TYPE            => 'No type given to check upon',
        self::MSG_VALUE_IS_AN_OBJECT => 'Given value is an object',
        self::MSG_WRONG_TYPE         => '%s is not a(n) %s',
    ];

    /**
     * @inheritDoc
     * @param string|null $type
     */
    public function isValid($value, string $type = null): bool
    {
        if (null === $type) {
            $this->error(self::MSG_NO_TYPE);
        }

        if (true === is_object($value)) {
            $this->error(self::MSG_VALUE_IS_AN_OBJECT);
        }

        if ($type !== gettype($value) && 0 === count($this->getMessages())) {
            $this->error(self::MSG_WRONG_TYPE, gettype($value), $type);
        }

        return 0 === count($this->getMessages());
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use PayNL\Sdk\{
    Exception\EmptyRequiredMemberException,
    Exception\LogicException,
    Exception\MissingRequiredMemberException,
    Exception\RuntimeException,
    Validator\RequiredMembers as RequiredMembersValidator
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

        // validate object
//        $validator = new RequiredMembersValidator();
//        $isValid = $validator->isValid($this);
//        if (false === $isValid) {
//            // create exception stack
//            $c = 0;
//            $prev = null;
//            foreach ($validator->getMessages() as $type => $message) {
//                $exceptionClass = MissingRequiredMemberException::class;
//                if (true === in_array($type, [RequiredMembersValidator::MSG_EMPTY_MEMBER, RequiredMembersValidator::MSG_EMPTY_MEMBERS], true)) {
//                    $exceptionClass = EmptyRequiredMemberException::class;
//                }
//                $e = new $exceptionClass($message, 500, ($c++ !== 0 ? $prev : null));
//                $prev = $e;
//            }
//
//            throw new RuntimeException(
//                sprintf(
//                    'Object "%s" is not valid',
//                    __CLASS__
//                ),
//                500,
//                $prev
//            );
//        }

        $vars = get_object_vars($this);
        if ($this instanceof ArrayCollection) {
            return $this->toArray();
        }

        return array_filter($vars, static function (&$var) {
            if (true === is_object($var) && true === method_exists($var, 'jsonSerialize')) {
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

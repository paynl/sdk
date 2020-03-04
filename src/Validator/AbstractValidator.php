<?php

declare(strict_types=1);

namespace PayNL\Sdk\Validator;

use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class AbstractValidator
 *
 * @package PayNL\Sdk\Validator
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $messageTemplates = [];

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     *
     * @return AbstractValidator
     */
    public function setMessages(array $messages): self
    {
        foreach ($messages as $key => $message) {
            $this->addMessage($message, $key);
        }
        return $this;
    }

    /**
     * @param string $message
     * @param mixed $messageKey
     *
     * @throws InvalidArgumentException when message key given is not a string nor an integer
     *
     * @return AbstractValidator
     */
    public function addMessage(string $message, $messageKey): self
    {
        if (false === is_string($messageKey) && false === is_int($messageKey)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Message key must be a string or an integer, %s given',
                    is_object($messageKey) === true ? get_class($messageKey) : gettype($messageKey)
                )
            );
        }

        $this->messages[$messageKey] = $message;
        return $this;
    }

    /**
     * Quickly add an error based on the given arguments
     *
     * @param string $messageKey
     * @param mixed ...$arguments
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public function error(string $messageKey, ...$arguments): void
    {
        if (false === array_key_exists($messageKey, $this->messageTemplates)) {
            throw new InvalidArgumentException(
                sprintf(
                    'No message template found for key "%s"',
                    $messageKey
                )
            );
        }

        $message = $this->messageTemplates[$messageKey];
        if (0 < count($arguments)) {
            array_unshift($arguments, $message);
            $message = sprintf(...$arguments);
        }

        $this->addMessage($message, $messageKey);
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\IsPay;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Validator\InputType;

/**
 * Class Get
 *
 * @package PayNL\Sdk\Request\IsPay
 */
class Get extends AbstractRequest
{
    /*
     * Type constants definition
     */
    public const TYPE_IP = 'ip';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string|int
     */
    protected $value;

    public function __construct(string $type, $value)
    {
        $validator = new InputType();
        if (false === $validator->isValid($value, 'string') && false === $validator->isValid($value, 'int')) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $validator->getMessages())
            );
        }

        $this->setType($type)
            ->setValue($value)
        ;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return Get
     */
    protected function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return Get
     */
    protected function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return static::METHOD_GET;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return "ispay/{$this->getType()}?value={$this->getValue()}";
    }
}
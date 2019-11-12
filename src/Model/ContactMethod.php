<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class ContactMethod
 *
 * @package PayNL\Sdk\Model
 */
class ContactMethod implements ModelInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $description;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return ContactMethod
     */
    public function setType(string $type): ContactMethod
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return ContactMethod
     */
    public function setValue(string $value): ContactMethod
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return ContactMethod
     */
    public function setDescription(string $description): ContactMethod
    {
        $this->description = $description;
        return $this;
    }
}

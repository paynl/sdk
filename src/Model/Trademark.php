<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;

/**
 * Class Trademark
 *
 * @package PayNL\Sdk\Model
 */
class Trademark implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Trademark
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Trademark
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
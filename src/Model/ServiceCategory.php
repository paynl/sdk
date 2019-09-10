<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class ServiceCategory
 *
 * @package PayNL\Sdk\Model
 */
class ServiceCategory implements ModelInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ServiceCategory
     */
    public function setId(int $id): self
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
     * @return ServiceCategory
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}

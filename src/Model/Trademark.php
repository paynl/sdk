<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Trademark
 *
 * @package PayNL\Sdk\Model
 */
class Trademark implements ModelInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $trademark;

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
    public function getTrademark(): string
    {
        return $this->trademark;
    }

    /**
     * @param string $trademark
     *
     * @return Trademark
     */
    public function setTrademark(string $trademark): self
    {
        $this->trademark = $trademark;
        return $this;
    }
}

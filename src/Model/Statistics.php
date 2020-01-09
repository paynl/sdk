<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Statistics
 *
 * @package PayNL\Sdk\Model
 */
class Statistics implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var string
     */
    protected $object;

    /**
     * @var string
     */
    protected $info;

    /**
     * @var string
     */
    protected $tool;

    /**
     * @var string
     */
    protected $extra1;

    /**
     * @var string
     */
    protected $extra2;

    /**
     * @var string
     */
    protected $extra3;

    /**
     * @return string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    /**
     * @param string $object
     *
     * @return Statistics
     */
    public function setObject(string $object): self
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * @param string $info
     *
     * @return Statistics
     */
    public function setInfo(string $info): self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return string
     */
    public function getTool(): string
    {
        return $this->tool;
    }

    /**
     * @param string $tool
     *
     * @return Statistics
     */
    public function setTool(string $tool): self
    {
        $this->tool = $tool;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtra1(): string
    {
        return $this->extra1;
    }

    /**
     * @param string $extra1
     *
     * @return Statistics
     */
    public function setExtra1(string $extra1): self
    {
        $this->extra1 = $extra1;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtra2(): string
    {
        return $this->extra2;
    }

    /**
     * @param string $extra2
     *
     * @return Statistics
     */
    public function setExtra2(string $extra2): self
    {
        $this->extra2 = $extra2;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtra3(): string
    {
        return $this->extra3;
    }

    /**
     * @param string $extra3
     *
     * @return Statistics
     */
    public function setExtra3(string $extra3): self
    {
        $this->extra3 = $extra3;
        return $this;
    }
}

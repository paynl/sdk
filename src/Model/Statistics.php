<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use \JsonSerializable;

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
    protected $promoterId;

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
     * @var array
     */
    protected $transferData = [];

    /**
     * @return string
     */
    public function getPromoterId(): string
    {
        return $this->promoterId;
    }

    /**
     * @param string $promoterId
     *
     * @return Statistics
     */
    public function setPromoterId(string $promoterId): Statistics
    {
        $this->promoterId = $promoterId;
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
    public function setInfo(string $info): Statistics
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
    public function setTool(string $tool): Statistics
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
    public function setExtra1(string $extra1): Statistics
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
    public function setExtra2(string $extra2): Statistics
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
    public function setExtra3(string $extra3): Statistics
    {
        $this->extra3 = $extra3;
        return $this;
    }

    /**
     * @return array
     */
    public function getTransferData(): array
    {
        return $this->transferData;
    }

    /**
     * @param array $transferData
     *
     * @return Statistics
     */
    public function setTransferData(array $transferData): Statistics
    {
        $this->transferData = $transferData;
        return $this;
    }
}

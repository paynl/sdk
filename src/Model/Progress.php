<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Progress
 *
 * @package PayNL\Sdk\Model
 */
class Progress implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;
    
    /**
     * @var integer
     */
    protected $percentage;

    /**
     * @var integer
     */
    protected $secondsPassed;

    /**
     * @var float
     */
    protected $percentagePerSecond;

    /**
     * @return int
     */
    public function getPercentage(): int
    {
        return (int)$this->percentage;
    }

    /**
     * @param int $percentage
     *
     * @return Progress
     */
    public function setPercentage(int $percentage): self
    {
        $this->percentage = $percentage;
        return $this;
    }

    /**
     * @return int
     */
    public function getSecondsPassed(): int
    {
        return (int)$this->secondsPassed;
    }

    /**
     * @param int $secondsPassed
     *
     * @return Progress
     */
    public function setSecondsPassed(int $secondsPassed): self
    {
        $this->secondsPassed = $secondsPassed;
        return $this;
    }

    /**
     * @return float
     */
    public function getPercentagePerSecond(): float
    {
        return (float)$this->percentagePerSecond;
    }

    /**
     * @param float $percentagePerSecond
     *
     * @return Progress
     */
    public function setPercentagePerSecond(float $percentagePerSecond): self
    {
        $this->percentagePerSecond = $percentagePerSecond;
        return $this;
    }
}

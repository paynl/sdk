<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Common\JsonSerializeTrait
};

/**
 * Class Integration
 *
 * @package PayNL\Sdk\Model
 */
class Integration implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /*
     * Test mode constant definitions
     */
    public const TEST_MODE_OFF = false;
    public const TEST_MODE_ON  = true;

    /**
     * @required
     *
     * @var integer
     */
    protected $testMode = self::TEST_MODE_OFF;

    /**
     * @return array
     */
    protected function getTestModes(): array
    {
        return [
            static::TEST_MODE_OFF,
            static::TEST_MODE_ON,
        ];
    }

    /**
     * @return integer
     */
    public function getTestMode(): int
    {
        return $this->testMode;
    }

    /**
     * @param boolean $testMode
     *
     * @throws InvalidArgumentException when given test mode is invalid
     *
     * @return Integration
     */
    public function setTestMode(bool $testMode): self
    {
        $allowedModes = $this->getTestModes();
        if (false === in_array($testMode, $allowedModes, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given test mode "%d" is not allowed, choose one of: "%s"',
                    $testMode,
                    implode('", "', $allowedModes)
                )
            );
        }

        $this->testMode = $testMode;
        return $this;
    }
}

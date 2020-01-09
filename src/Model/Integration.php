<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Integration
 *
 * @package PayNL\Sdk\Model
 */
class Integration implements ModelInterface, JsonSerializable
{
    /*
     * Test mode constant definitions
     */
    public const TEST_MODE_OFF = 0;
    public const TEST_MODE_ON  = 1;

    /*
     * Log mode constant definitions
     */
//    public const LOG_MODE_OFF  = 0;
//    public const LOG_MODE_ALL  = 1;
//    public const LOG_MODE_ERR  = 2;

    use JsonSerializeTrait;

    /**
     * @required
     *
     * @var integer
     */
    protected $testMode = self::TEST_MODE_OFF;

    /**
     * @var integer
     */
//    protected $logMode = self::LOG_MODE_OFF;

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
     * @param integer $testMode
     *
     * @throws InvalidArgumentException when given test mode is invalid
     *
     * @return Integration
     */
    public function setTestMode(int $testMode): self
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

    /**
     * @return array
     */
//    protected function getLogModes(): array
//    {
//        return [
//            static::LOG_MODE_OFF,
//            static::LOG_MODE_ALL,
//            static::LOG_MODE_ERR,
//        ];
//    }

    /**
     * @return int
     */
//    public function getLogMode(): int
//    {
//        return $this->logMode;
//    }

    /**
     * @param int $logMode
     *
     * @throws InvalidArgumentException when given log mode is invalid
     *
     * @return Integration
     */
//    public function setLogMode(int $logMode): self
//    {
//        $allowedModes = $this->getLogModes();
//        if (false === in_array($logMode, $allowedModes, true)) {
//            throw new InvalidArgumentException(
//                sprintf(
//                    'Log mode "%d" is not allowed, choose one of: "%s"',
//                    $logMode,
//                    implode('", "', $allowedModes)
//                )
//            );
//        }
//
//        $this->logMode = $logMode;
//        return $this;
//    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Integration
 *
 * @package PayNL\Sdk\Model
 */
class Integration implements
    ModelInterface,
    JsonSerializable
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
     * @var bool
     */
    protected $testMode = self::TEST_MODE_OFF;

    /**
     * @return bool
     */
    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * @param bool $testMode
     *
     * @return Integration
     */
    public function setTestMode(bool $testMode): self
    {
        $this->testMode = $testMode;
        return $this;
    }
}

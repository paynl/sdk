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
     * @var boolean
     */
    protected $testMode = self::TEST_MODE_OFF;

    /**
     * @return boolean
     */
    public function isTestMode(): bool
    {
        return $this->testMode;
    }

    /**
     * @param boolean $testMode
     *
     * @return Integration
     */
    public function setTestMode(bool $testMode): self
    {
        $this->testMode = $testMode;
        return $this;
    }
}

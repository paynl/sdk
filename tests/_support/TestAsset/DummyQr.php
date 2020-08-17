<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use JsonSerializable;

/**
 * Class DummyQr
 *
 * @package Codeception\TestAsset
 */
class DummyQr implements DummyInterface, JsonSerializable
{
    protected $options = [];

    private $uuid;

    private $secret;

    /**
     * Dummy constructor.
     *
     * @param array|null $options
     */
    public function __construct(array $options = null)
    {
        if (null !== $options) {
            $this->options = $options;
        }
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'requiredMember' => $this->getRequiredMember(),
        ];
    }

    /**
     * @return string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @returns void
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     * @returns void
     */
    public function setSecret($secret): void
    {
        $this->secret = $secret;
    }
}

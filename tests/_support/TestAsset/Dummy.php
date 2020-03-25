<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use JsonSerializable;

/**
 * Class Dummy
 *
 * @package Codeception\TestAsset
 */
class Dummy implements DummyInterface, JsonSerializable
{
    protected $options = [];

    /**
     * @required
     * @var string
     */
    protected $requiredMember;

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
     * @param string $value
     */
    public function setRequiredMember(string $value): void
    {
        $this->requiredMember = $value;
    }

    /**
     * @return string
     */
    public function getRequiredMember(): string
    {
        return (string)$this->requiredMember;
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
}

<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

/**
 * Class Dummy
 *
 * @package Codeception\TestAsset
 */
class Dummy
{
    protected $options = [];

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
}

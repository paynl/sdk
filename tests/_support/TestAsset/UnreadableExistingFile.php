<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

/**
 * Class InvokableObject
 *
 * @package Codeception\TestAsset
 */
class UnreadableExistingFile
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * InvokableObject constructor.
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

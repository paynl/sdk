<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

/**
 * Class InvokableObject
 *
 * @package Codeception\TestAsset
 */
class InvokableObject
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $foo = '';

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

    /**
     * @return string
     */
    public function getFoo(): string
    {
        return $this->foo;
    }

    /**
     * @param string $foo
     *
     * @return InvokableObject
     */
    public function setFoo(string $foo): self
    {
        $this->foo = $foo;
        return $this;
    }
}

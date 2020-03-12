<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Filter\FilterInterface;

class DummyFilter implements FilterInterface
{
    private $value;

    /**
     * @inheritDoc
     */
    public function __construct($value = null)
    {
    }

    /**
     * @inheritDoc
     */
    public function setValue($value): FilterInterface
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->value ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'DummyFilter';
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

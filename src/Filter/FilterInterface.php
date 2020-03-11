<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Interface FilterInterface
 *
 * @package PayNL\Sdk\Filter
 */
interface FilterInterface
{
    /**
     * FilterInterface constructor.
     *
     * @param mixed $value
     */
    public function __construct($value = null);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setValue($value): self;

    /**
     * @return string
     */
    public function __toString(): string;
}

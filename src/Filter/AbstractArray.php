<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class AbstractArray
 *
 * @package PayNL\Sdk\Filter
 */
abstract class AbstractArray implements FilterInterface
{
    /**
     * @var array
     */
    protected $values = [];

    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return string
     */
    final public function getValue(): string
    {
        $output = '';
        $values = $this->getValues();
        array_walk_recursive($values, static function ($item, $key) use (&$output) {
            $output .= "{$key}: {$item}, ";
        });
        return trim($output, ', ');
    }

    /**
     * @inheritDoc
     */
    public function setValue($value)
    {
        if (false === is_array($value)) {
            $value = [$value];
        }
        return $this->setValues($value);
    }

    /**
     * @param array $values
     *
     * @return AbstractArray
     */
    public function setValues(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $filterString = '';
        foreach ($this->getValues() as $key => $value) {
            $filterKey = "{$this->getName()}[{$key}]";
            if (true === is_array($value)) {
                foreach ($value as $innerKey => $innerValue) {
                    $filterString .= "{$filterKey}[$innerKey]={$innerValue}&";
                }
                continue;
            }
            $filterString .= "{$filterKey}={$value}&";
        }
        return rtrim($filterString, '&');
    }
}

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

    /**
     * AbstractArray constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->setValues($values);
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
        return implode($this->getValues());
    }

    /**
     * @param array $values
     *
     * @return AbstractArray
     */
    protected function setValues(array $values): self
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

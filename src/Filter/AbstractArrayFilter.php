<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class AbstractArrayFilter
 *
 * @package PayNL\Sdk\Filter
 */
abstract class AbstractArrayFilter implements FilterInterface
{
    protected $values = [];

    public function __construct(array $values)
    {
        $this->setValues($values);
    }

    public function getValues(): array
    {
        return $this->values;
    }

    final public function getValue(): string
    {
        return implode($this->getValues());
    }

    public function setValues(array $values): self
    {
        $this->values = $values;
        return $this;
    }

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

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

/**
 * Trait OptionsTrait
 *
 * @package PayNL\Sdk\Common
 */
trait OptionsAwareTrait
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getOption(string $name)
    {
        return $this->options[$name] ?? null;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasOption(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * @param array $options
     *
     * @return static
     */
    public function setOptions(array $options)
    {
        if (0 === count($options)) {
            return $this;
        }

        foreach ($options as $name => $value) {
            $this->addOption($name, $value);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return static
     */
    public function addOption(string $name, $value): self
    {
        $this->options[$name] = $value;
        return $this;
    }
}

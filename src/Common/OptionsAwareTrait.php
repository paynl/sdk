<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use PayNL\Sdk\Exception\InvalidArgumentException;
use Traversable;

/**
 * Trait OptionsTrait
 *
 * Contains the necessary methods which are declared in the corresponding interface
 *  @see OptionsAwareInterface and a little bit more
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
     * @inheritDoc
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
     * @inheritDoc
     *
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setOptions($options): self
    {
        if (false === is_array($options) && false === ($options instanceof Traversable)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given options should be an array or an instance of %s, %s given',
                    Traversable::class,
                    (is_object($options) === true ? get_class($options) : gettype($options))
                )
            );
        }

        $this->clear();

        foreach ($options as $name => $value) {
            $this->addOption($name, $value);
        }

        return $this;
    }

    /**
     * @param string|int $name
     * @param mixed $value
     *
     * @return static
     */
    public function addOption($name, $value): self
    {
        $this->options[$name] = $value;
        return $this;
    }

    /**
     * @return static
     */
    protected function clear(): self
    {
        $this->options = [];
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class AbstractMapper
 *
 * @package PayNL\Sdk\Mapper
 */
abstract class AbstractMapper implements MapperInterface
{
    /**
     * @var array
     */
    protected $map = [];

    /**
     * AbstractMapper constructor.
     *
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @return array
     */
    public function getMapping(): array
    {
        return $this->map;
    }

    /**
     * @param string|object $target
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function getSource($target): string
    {
        if (true === is_object($target)) {
            $target = get_class($target);
        } elseif (false === is_string($target)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given target must be a string or an object, %s given',
                    gettype($target)
                )
            );
        }

        return array_search($target, $this->map, true) ?: '';
    }

    /**
     * @param string|object $source
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function getTarget($source): string
    {
        if (true === is_object($source)) {
            $source = get_class($source);
        } elseif (false === is_string($source)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Given source must be a string or an object, %s given',
                    gettype($source)
                )
            );
        }

        return $this->map[$source] ?? '';
    }
}

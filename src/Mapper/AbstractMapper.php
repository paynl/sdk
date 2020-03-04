<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

/**
 * Class AbstractMapper
 *
 * @package PayNL\Sdk\Mapper
 */
abstract class AbstractMapper implements MapperInterface
{
    protected $map;

    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function getMapping(): array
    {
        return $this->map;
    }

    public function getSource($target)
    {
        if (true === is_object($target)) {
            $target = get_class($target);
        }

        return array_search($target, $this->map, true) ?: null;
    }

    public function getTarget($source)
    {
        if (true === is_object($source)) {
            $source = get_class($source);
        }

        return $this->map[$source] ?? null;
    }
}

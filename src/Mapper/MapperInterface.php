<?php

declare(strict_types=1);

namespace PayNL\Sdk\Mapper;

/**
 * Interface MapperInterface
 *
 * @package PayNL\Sdk\Mapper
 */
interface MapperInterface
{
    /**
     * @return array
     */
    public function getMapping(): array;
}

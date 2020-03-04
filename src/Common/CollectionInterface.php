<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

/**
 * Interface CollectionInterface
 *
 * @package PayNL\Sdk\Common
 */
interface CollectionInterface
{
    /**
     * @return string
     */
    public function getCollectionName(): string;
}

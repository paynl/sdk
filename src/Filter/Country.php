<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class Country
 *
 * @package PayNL\Sdk\Filter
 */
class Country extends AbstractArray
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'country';
    }
}

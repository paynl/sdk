<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class Filters
 *
 * @package PayNL\Sdk\Filter
 */
class Filters extends AbstractArrayFilter
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'filters';
    }
}

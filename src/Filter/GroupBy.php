<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class GroupBy
 *
 * @package PayNL\Sdk\Filter
 */
class GroupBy extends AbstractArrayFilter
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'groupBy';
    }
}

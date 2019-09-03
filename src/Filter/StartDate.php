<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class StartDate
 *
 * @package PayNL\Sdk\Filter
 */
class StartDate extends AbstractDateFilter
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'startDate';
    }
}

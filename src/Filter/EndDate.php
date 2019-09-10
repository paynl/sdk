<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class EndDate
 *
 * @package PayNL\Sdk\Filter
 */
class EndDate extends AbstractDate
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'endDate';
    }
}

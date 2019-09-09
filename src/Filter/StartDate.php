<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class StartDate
 *
 * @package PayNL\Sdk\Filter
 */
class StartDate extends AbstractDate
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'startDate';
    }
}

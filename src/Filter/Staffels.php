<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class Staffels
 *
 * @package PayNL\Sdk\Filter
 */
class Staffels extends AbstractScalarFilter
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'staffels';
    }
}

<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class Staffels
 *
 * @package PayNL\Sdk\Filter
 */
class Staffels extends AbstractScalar
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'staffels';
    }
}

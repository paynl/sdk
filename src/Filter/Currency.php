<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class Currency
 *
 * @package PayNL\Sdk\Filter
 */
class Currency extends AbstractScalar
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'currency';
    }
}
